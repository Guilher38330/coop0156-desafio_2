<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Retorna um payload padrão para testes de cliente.
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nome'         => 'Maria Silva',
            'cpf'          => '12345678901',
            'email'        => 'maria@example.com',
            'telefone'     => '11999999999',
            'renda_mensal' => 3500.50,
        ], $overrides);
    }

    /**
     * Testa criação de cliente com dados válidos (HTTP 201).
     */
    public function test_criacao_cliente_dados_validos(): void
    {
        $response = $this->postJson('/api/clientes', $this->payload());

        $response->assertStatus(201)
            ->assertJsonFragment([
                'nome'  => 'Maria Silva',
                'cpf'   => '12345678901',
                'email' => 'maria@example.com',
            ]);

        $this->assertDatabaseHas('clientes', ['cpf' => '12345678901']);
    }

    /**
     * Testa falha de validação (HTTP 422) ao omitir campos obrigatórios no cadastro.
     */
    public function test_validacao_campos_obrigatorios(): void
    {
        $response = $this->postJson('/api/clientes', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'cpf', 'email', 'renda_mensal']);
    }

    /**
     * Testa rejeição (HTTP 422) ao tentar cadastrar cliente com CPF já existente.
     */
    public function test_cpf_duplicado(): void
    {
        Cliente::create($this->payload());

        $response = $this->postJson('/api/clientes', $this->payload([
            'email' => 'outro@example.com',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cpf']);
    }

    /**
     * Testa rejeição (HTTP 422) ao tentar cadastrar cliente com e-mail já existente.
     */
    public function test_email_duplicado(): void
    {
        Cliente::create($this->payload());

        $response = $this->postJson('/api/clientes', $this->payload([
            'cpf' => '10987654321',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Testa listagem paginada de clientes com tamanho padrão de página.
     */
    public function test_listagem_paginada(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Cliente::create($this->payload([
                'cpf'   => str_pad((string) $i, 11, '0', STR_PAD_LEFT),
                'email' => "teste{$i}@example.com",
            ]));
        }

        $response = $this->getJson('/api/clientes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'last_page',
                'total',
            ]);

        $this->assertCount(15, $response->json('data'));
    }

    /**
     * Testa exibição dos dados de um cliente existente por ID.
     */
    public function test_exibicao_cliente_existente(): void
    {
        $cliente = Cliente::create($this->payload());

        $response = $this->getJson("/api/clientes/{$cliente->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id'   => $cliente->id,
                'nome' => $cliente->nome,
            ]);
    }

    /**
     * Testa retorno 404 ao buscar um cliente com ID inexistente.
     */
    public function test_exibicao_cliente_inexistente(): void
    {
        $response = $this->getJson('/api/clientes/9999');

        $response->assertStatus(404);
    }

    /**
     * Testa atualização parcial dos dados de um cliente existente.
     */
    public function test_atualizacao_parcial(): void
    {
        $cliente = Cliente::create($this->payload());

        $response = $this->putJson("/api/clientes/{$cliente->id}", [
            'nome' => 'Nome Atualizado',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id'   => $cliente->id,
                'nome' => 'Nome Atualizado',
                'cpf'  => '12345678901',
            ]);

        $this->assertDatabaseHas('clientes', [
            'id'   => $cliente->id,
            'nome' => 'Nome Atualizado',
        ]);
    }

    /**
     * Testa remoção de cliente existente (HTTP 204 No Content).
     */
    public function test_remocao_cliente(): void
    {
        $cliente = Cliente::create($this->payload());

        $response = $this->deleteJson("/api/clientes/{$cliente->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    /**
     * Testa retorno 404 ao tentar remover um cliente inexistente.
     */
    public function test_remocao_cliente_inexistente(): void
    {
        $response = $this->deleteJson('/api/clientes/9999');

        $response->assertStatus(404);
    }
}
