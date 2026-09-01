<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    /**
     * Retorna a lista paginada de clientes.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listar()
    {
        return Cliente::paginate(15);
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
}
