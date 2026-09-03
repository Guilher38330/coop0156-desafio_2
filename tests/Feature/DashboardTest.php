<?php

namespace Tests\Feature;

use App\Enums\StatusAnalise;
use App\Enums\TipoCredito;
use App\Models\AnaliseCredito;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa retorno das métricas com banco de dados vazio.
     */
    public function test_metricas_dashboard_sem_dados(): void
    {
        $response = $this->getJson('/api/dashboard/metricas');

        $response->assertStatus(200)
            ->assertJson([
                'total_solicitacoes' => 0,
                'total_aprovadas'    => 0,
                'total_reprovadas'   => 0,
                'total_contratadas'  => 0,
                'taxa_aprovacao'     => 0,
                'volume_solicitado'  => 0,
                'volume_aprovado'    => 0,
                'volume_contratado'  => 0,
                'total_clientes'     => 0,
                'ultimas_analises'   => [],
            ]);
    }

    /**
     * Testa cálculo consolidado de métricas e KPIs financeiros com dados reais.
     */
    public function test_metricas_dashboard_com_dados_calculadas_corretamente(): void
    {
        $cliente = Cliente::create([
            'nome'         => 'Carlos Pereira',
            'cpf'          => '11122233344',
            'email'        => 'carlos@example.com',
            'renda_mensal' => 5000.00,
        ]);

        /** Análise aprovada de R$ 10.000,00 */
        AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => $cliente->cpf,
            'nome'             => $cliente->nome,
            'renda_mensal'     => 5000.00,
            'tipo_credito'     => TipoCredito::PESSOAL,
            'valor_solicitado' => 10000.00,
            'status'           => StatusAnalise::APROVADO,
            'score'            => 850,
            'taxa_juros'       => 2.9,
            'valor_parcela'    => 1123.33,
        ]);

        /** Análise contratada de R$ 20.000,00 */
        AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => $cliente->cpf,
            'nome'             => $cliente->nome,
            'renda_mensal'     => 5000.00,
            'tipo_credito'     => TipoCredito::IMOBILIARIO,
            'valor_solicitado' => 20000.00,
            'status'           => StatusAnalise::CONTRATADO,
            'score'            => 750,
            'taxa_juros'       => 2.9,
            'valor_parcela'    => 2246.67,
        ]);

        /** Análise reprovada de R$ 5.000,00 */
        AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => $cliente->cpf,
            'nome'             => $cliente->nome,
            'renda_mensal'     => 5000.00,
            'tipo_credito'     => TipoCredito::AUTOMOTIVO,
            'valor_solicitado' => 5000.00,
            'status'           => StatusAnalise::REPROVADO,
            'score'            => 300,
            'motivo_rejeicao'  => 'Score de crédito muito baixo',
        ]);

        $response = $this->getJson('/api/dashboard/metricas');

        $response->assertStatus(200)
            ->assertJson([
                'total_solicitacoes' => 3,
                'total_aprovadas'    => 2,
                'total_reprovadas'   => 1,
                'total_contratadas'  => 1,
                'taxa_aprovacao'     => 66.7,
                'volume_solicitado'  => 35000.00,
                'volume_aprovado'    => 30000.00,
                'volume_contratado'  => 20000.00,
                'total_clientes'     => 1,
            ]);

        $this->assertCount(3, $response->json('ultimas_analises'));
    }

    /**
     * Testa listagem de análises de crédito com filtros por status e busca textual.
     */
    public function test_listagem_analises_com_filtros(): void
    {
        $cliente = Cliente::create([
            'nome'         => 'Lucas Martins',
            'cpf'          => '55566677788',
            'email'        => 'lucas@example.com',
            'renda_mensal' => 6000.00,
        ]);

        AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => $cliente->cpf,
            'nome'             => $cliente->nome,
            'renda_mensal'     => 6000.00,
            'tipo_credito'     => TipoCredito::PESSOAL,
            'valor_solicitado' => 8000.00,
            'status'           => StatusAnalise::APROVADO,
            'score'            => 800,
        ]);

        AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => '99988877766',
            'nome'             => 'Outro Cliente',
            'renda_mensal'     => 2000.00,
            'tipo_credito'     => TipoCredito::PESSOAL,
            'valor_solicitado' => 4000.00,
            'status'           => StatusAnalise::REPROVADO,
            'motivo_rejeicao'  => 'Score de crédito muito baixo',
        ]);

        $response = $this->getJson('/api/analises-credito');
        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'total', 'current_page']);
        $this->assertEquals(2, $response->json('total'));

        $responseAprovados = $this->getJson('/api/analises-credito?status=aprovado');
        $responseAprovados->assertStatus(200);
        $this->assertEquals(1, $responseAprovados->json('total'));
        $this->assertEquals('aprovado', $responseAprovados->json('data.0.status'));

        $responseBusca = $this->getJson('/api/analises-credito?busca=Lucas');
        $responseBusca->assertStatus(200);
        $this->assertEquals(1, $responseBusca->json('total'));
        $this->assertEquals('Lucas Martins', $responseBusca->json('data.0.nome'));
    }

    /**
     * Testa recuperação do histórico de análises de crédito de um cliente específico.
     */
    public function test_historico_analises_do_cliente(): void
    {
        $cliente = Cliente::create([
            'nome'         => 'Ana Oliveira',
            'cpf'          => '98765432100',
            'email'        => 'ana@example.com',
            'renda_mensal' => 7000.00,
        ]);

        AnaliseCredito::create([
            'cliente_id'       => $cliente->id,
            'cpf'              => $cliente->cpf,
            'nome'             => $cliente->nome,
            'renda_mensal'     => 7000.00,
            'tipo_credito'     => TipoCredito::PESSOAL,
            'valor_solicitado' => 15000.00,
            'status'           => StatusAnalise::APROVADO,
            'score'            => 900,
        ]);

        $response = $this->getJson("/api/clientes/{$cliente->id}/analises");

        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
        $this->assertEquals('aprovado', $response->json('0.status'));
    }

    /**
     * Testa retorno 404 ao buscar histórico de análises de cliente inexistente.
     */
    public function test_historico_analises_cliente_inexistente(): void
    {
        $response = $this->getJson('/api/clientes/99999/analises');

        $response->assertStatus(404);
    }

    /**
     * Testa busca textual de clientes por nome e por CPF formatado.
     */
    public function test_busca_de_clientes(): void
    {
        Cliente::create([
            'nome'         => 'Rodrigo Santos',
            'cpf'          => '11111111111',
            'email'        => 'rodrigo@example.com',
            'renda_mensal' => 4000.00,
        ]);

        Cliente::create([
            'nome'         => 'Juliana Lima',
            'cpf'          => '22222222222',
            'email'        => 'juliana@example.com',
            'renda_mensal' => 4500.00,
        ]);

        $response = $this->getJson('/api/clientes?busca=Rodrigo');
        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('total'));
        $this->assertEquals('Rodrigo Santos', $response->json('data.0.nome'));

        $responseCpf = $this->getJson('/api/clientes?busca=222.222.222-22');
        $responseCpf->assertStatus(200);
        $this->assertEquals(1, $responseCpf->json('total'));
        $this->assertEquals('Juliana Lima', $responseCpf->json('data.0.nome'));
    }
}
