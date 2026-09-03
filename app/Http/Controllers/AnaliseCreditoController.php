<?php

namespace App\Http\Controllers;

use App\Exceptions\BureauIndisponivelException;
use App\Exceptions\BureauRespostaMalformadaException;
use App\Http\Requests\SolicitarAnaliseRequest;
use App\Services\AnaliseCreditoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AnaliseCreditoController extends Controller
{
    public function __construct(
        private readonly AnaliseCreditoService $analiseCreditoService
    ) {}

    /**
     * Lista as análises de crédito com filtros opcionais.
     *
     * GET /api/analises-credito
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filtros = [
            'status' => $request->query('status'),
            'cpf'    => $request->query('cpf'),
            'busca'  => $request->query('busca'),
        ];
        $perPage = (int) $request->query('per_page', 15);

        $analises = $this->analiseCreditoService->listar($filtros, $perPage);

        return response()->json($analises);
    }

    /**
     * Solicita uma nova análise de crédito.
     *
     * POST /api/analise-credito
     *
     * @param  SolicitarAnaliseRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function solicitar(SolicitarAnaliseRequest $request)
    {
        try {
            $analise = $this->analiseCreditoService->solicitar($request->validated());

            return response()->json($analise);
        } catch (BureauIndisponivelException) {
            return response()->json([
                'message' => 'Serviço do Bureau de Crédito indisponível. Tente novamente mais tarde.',
            ], 503);
        } catch (BureauRespostaMalformadaException) {
            return response()->json([
                'message' => 'Erro ao processar a resposta do Bureau de Crédito.',
            ], 502);
        }
    }

    /**
     * Confirma a contratação de uma análise de crédito aprovada.
     *
     * POST /api/analise-credito/{id}/contratar
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function contratar($id)
    {
        try {
            $analise = $this->analiseCreditoService->contratar($id);

            return response()->json($analise);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'Análise de crédito não encontrada.',
            ], 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
