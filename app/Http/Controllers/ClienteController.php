<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Services\ClienteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClienteController extends Controller
{
    public function __construct(
        private readonly ClienteService $clienteService
    ) {}

    /**
     * Lista todos os clientes cadastrados (paginado).
     *
     * GET /api/clientes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = $this->clienteService->listar();

        return response()->json($clientes);
    }

    /**
     * Cadastra um novo cliente.
     *
     * POST /api/clientes
     *
     * @param  StoreClienteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClienteRequest $request)
    {
        $cliente = $this->clienteService->criar($request->validated());

        return response()->json($cliente, 201);
    }

    /**
     * Exibe os dados de um cliente específico.
     *
     * GET /api/clientes/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $cliente = $this->clienteService->buscar($id);

            return response()->json($cliente);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }
    }

    /**
     * Atualiza os dados de um cliente existente.
     *
     * PUT /api/clientes/{id}
     *
     * @param  UpdateClienteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClienteRequest $request, $id)
    {
        try {
            $cliente = $this->clienteService->atualizar($id, $request->validated());

            return response()->json($cliente);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }
    }

    /**
     * Remove um cliente do sistema.
     *
     * DELETE /api/clientes/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->clienteService->deletar($id);

            return response()->noContent();
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }
    }
}
