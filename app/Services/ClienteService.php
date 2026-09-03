<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    /**
     * Retorna a lista paginada de clientes com suporte a busca.
     *
     * @param  string|null  $busca
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listar(?string $busca = null, int $perPage = 15)
    {
        $query = Cliente::query()->latest('id');

        if ($busca) {
            $cpfLimpo = preg_replace('/\D/', '', $busca);
            $query->where(function ($q) use ($busca, $cpfLimpo) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('email', 'like', "%{$busca}%");

                if (!empty($cpfLimpo)) {
                    $q->orWhere('cpf', 'like', "%{$cpfLimpo}%");
                }
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Cria um novo cliente com os dados validados.
     *
     * @param  array  $dados
     * @return Cliente
     */
    public function criar(array $dados): Cliente
    {
        return Cliente::create($dados);
    }

    /**
     * Busca um cliente pelo ID.
     *
     * @param  int  $id
     * @return Cliente
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function buscar(int $id): Cliente
    {
        return Cliente::findOrFail($id);
    }

    /**
     * Atualiza um cliente existente com os dados validados.
     *
     * @param  int    $id
     * @param  array  $dados
     * @return Cliente
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function atualizar(int $id, array $dados): Cliente
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($dados);

        return $cliente;
    }

    /**
     * Remove um cliente pelo ID.
     *
     * @param  int  $id
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deletar(int $id): void
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
    }

    /**
     * Retorna o histórico de análises de crédito de um cliente.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function obterAnalises(int $id)
    {
        $cliente = Cliente::findOrFail($id);

        return $cliente->analises()->latest()->get();
    }
}
