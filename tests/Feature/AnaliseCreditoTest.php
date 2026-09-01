<?php

namespace Tests\Feature;

use App\Enums\StatusAnalise;
use App\Models\AnaliseCredito;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AnaliseCreditoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Retorna um payload padrão para solicitação de análise.
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nome'             => 'João da Silva',
            'cpf'              => '12345678903',
            'renda_mensal'     => 5000.00,
            'tipo_credito'     => 'pessoal',
            'valor_solicitado' => 10000.00,
        ], $overrides);
    }

    /**
     * Simula a resposta do Bureau com um score específico.
     */
    private function fakeBureau(int $score): void
    {
        Http::fake([
            '*/api/mock/bureau/*' => Http::response([
                'cpf'      => '00000000000',
                'score'    => $score,
                'situacao' => 'ativo',
            ]),
        ]);
    }

    // =========================================================================
    // Testes de Aprovação
    // =========================================================================

    public function test_aprovacao_score_alto_taxa_2_9(): void
    {
        $this->fakeBureau(850);

        $response = $this->postJson('/api/analise-credito', $this->payload());

        // Parcela: 10000 * 0.029 * 12 = 3480 → total = 13480 → parcela = 1123.33
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status'     => 'aprovado',
                'score'      => 850,
                'taxa_juros' => '2.90',
                'valor_parcela' => '1123.33',
            ])
            ->assertJsonMissing(['motivo_rejeicao' => 'Renda mínima insuficiente']);
    }

    public function test_aprovacao_score_medio_taxa_4_5(): void
    {
        $this->fakeBureau(550);

        $response = $this->postJson('/api/analise-credito', $this->payload([
            'valor_solicitado' => 5000.00,
        ]));

        // Parcela: 5000 * 0.045 * 12 = 2700 → total = 7700 → parcela = 641.67
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status'        => 'aprovado',
                'score'         => 550,
                'taxa_juros'    => '4.50',
                'valor_parcela' => '641.67',
            ]);
    }

    // =========================================================================
    // Testes de Reprovação
    // =========================================================================

    public function test_reprovacao_renda_insuficiente(): void
    {
        Http::fake(); // Safety net — Bureau NÃO deve ser chamado

        $response = $this->postJson('/api/analise-credito', $this->payload([
            'renda_mensal' => 1000.00,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status'          => 'reprovado',
                'motivo_rejeicao' => 'Renda mínima insuficiente',
            ]);

        // Verifica que o Bureau não foi consultado (renda checada antes)
        Http::assertNothingSent();
    }

    public function test_reprovacao_score_baixo(): void
    {
        $this->fakeBureau(150);

        $response = $this->postJson('/api/analise-credito', $this->payload());

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status'          => 'reprovado',
                'score'           => 150,
                'motivo_rejeicao' => 'Score de crédito muito baixo',
            ]);
    }

    public function test_reprovacao_comprometimento_renda(): void
    {
        $this->fakeBureau(550);

        // Renda 2000, valor 10000, taxa 4.5%
        // Parcela: 10000 * 0.045 * 12 = 5400 → total = 15400 → parcela = 1283.33
        // Limite: 2000 * 0.30 = 600.00 → 1283.33 > 600 → reprovado
        $response = $this->postJson('/api/analise-credito', $this->payload([
            'renda_mensal'     => 2000.00,
            'valor_solicitado' => 10000.00,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status'          => 'reprovado',
                'motivo_rejeicao' => 'Comprometimento de renda superior a 30%',
            ]);
    }

    // =========================================================================
    // Testes de Resiliência do Bureau
    // =========================================================================

    public function test_bureau_erro_500(): void
    {
        Http::fake([
            '*/api/mock/bureau/*' => Http::response([
                'error' => 'Erro interno na comunicação com o provedor de score.',
            ], 500),
        ]);

        $response = $this->postJson('/api/analise-credito', $this->payload());

        $response->assertStatus(503)
            ->assertJsonFragment([
                'message' => 'Serviço do Bureau de Crédito indisponível. Tente novamente mais tarde.',
            ]);
    }

    public function test_bureau_resposta_malformada(): void
    {
        Http::fake([
            '*/api/mock/bureau/*' => Http::response([
                'cpf'            => '12345678906',
                'status_bureau'  => 'ok',
                // Sem a chave 'score'
            ]),
        ]);

        $response = $this->postJson('/api/analise-credito', $this->payload());

        $response->assertStatus(502)
            ->assertJsonFragment([
                'message' => 'Erro ao processar a resposta do Bureau de Crédito.',
            ]);
    }

    // =========================================================================
    // Testes de Contratação
    // =========================================================================

    public function test_contratacao_analise_aprovada(): void
    {
        \Illuminate\Support\Facades\Queue::fake();

        $cliente = Cliente::create([
            'nome'         => 'João da Silva',
            'cpf'          => '12345678903',
            'email'        => 'joao@test.com',
            'renda_mensal' => 5000.00,
        ]);

        $analise = AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => '12345678903',
            'nome'             => 'João da Silva',
            'renda_mensal'     => 5000.00,
            'tipo_credito'     => 'pessoal',
            'valor_solicitado' => 10000.00,
            'status'           => StatusAnalise::APROVADO,
            'score'            => 850,
            'taxa_juros'       => 2.90,
            'valor_parcela'    => 1123.33,
        ]);

        $response = $this->postJson("/api/analise-credito/{$analise->id}/contratar");

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'processando_contratacao']);

        $this->assertDatabaseHas('analises_credito', [
            'id'     => $analise->id,
            'status' => 'processando_contratacao',
        ]);

        \Illuminate\Support\Facades\Queue::assertPushed(\App\Jobs\ProcessarContratacaoJob::class, function ($job) use ($analise) {
            return $job->analiseId === $analise->id;
        });
    }

    public function test_contratacao_analise_nao_aprovada(): void
    {
        $cliente = Cliente::create([
            'nome'         => 'João da Silva',
            'cpf'          => '12345678903',
            'email'        => 'joao@test.com',
            'renda_mensal' => 5000.00,
        ]);

        $analise = AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => '12345678903',
            'nome'             => 'João da Silva',
            'renda_mensal'     => 5000.00,
            'tipo_credito'     => 'pessoal',
            'valor_solicitado' => 10000.00,
            'status'           => StatusAnalise::PENDENTE,
        ]);

        $response = $this->postJson("/api/analise-credito/{$analise->id}/contratar");

        $response->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'Apenas análises com status aprovado podem ser contratadas.',
            ]);
    }

    public function test_contratacao_analise_inexistente(): void
    {
        $response = $this->postJson('/api/analise-credito/9999/contratar');

        $response->assertStatus(404);
    }

    // =========================================================================
    // Testes de Criação Automática de Cliente
    // =========================================================================

    public function test_criacao_automatica_cliente_cpf_novo(): void
    {
        $this->fakeBureau(850);

        $cpf = '99988877703';

        $this->assertDatabaseMissing('clientes', ['cpf' => $cpf]);

        $response = $this->postJson('/api/analise-credito', $this->payload([
            'cpf' => $cpf,
        ]));

        $response->assertStatus(200);

        // O cliente foi criado automaticamente
        $this->assertDatabaseHas('clientes', [
            'cpf'  => $cpf,
            'nome' => 'João da Silva',
        ]);

        // A análise está vinculada ao cliente
        $this->assertDatabaseHas('analises_credito', [
            'cpf'    => $cpf,
            'status' => 'aprovado',
        ]);
    }

    // =========================================================================
    // Testes de Validação
    // =========================================================================

    public function test_validacao_campos_obrigatorios(): void
    {
        $response = $this->postJson('/api/analise-credito', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'cpf', 'renda_mensal', 'tipo_credito', 'valor_solicitado']);
    }
}
