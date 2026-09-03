<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    /**
     * Retorna métricas e indicadores de desempenho para o dashboard.
     *
     * GET /api/dashboard/metricas
     *
     * @return JsonResponse
     */
    public function metricas(): JsonResponse
    {
        $metricas = $this->dashboardService->obterMetricas();

        return response()->json($metricas);
    }
}
