<?php

namespace App\Services;

use App\Enums\StatusAnalise;
use App\Models\AnaliseCredito;
use App\Models\Cliente;

class DashboardService
{
    /**
     * Retorna indicadores e métricas consolidadas da cooperativa.
     *
     * @return array
     */
    public function obterMetricas(): array
    {
        $totalAnalises = AnaliseCredito::count();
        $totalAprovadas = AnaliseCredito::whereIn('status', [
            StatusAnalise::APROVADO->value,
            StatusAnalise::PROCESSANDO_CONTRATACAO->value,
            StatusAnalise::CONTRATADO->value,
        ])->count();
        $totalReprovadas = AnaliseCredito::where('status', StatusAnalise::REPROVADO->value)->count();
        $totalContratadas = AnaliseCredito::where('status', StatusAnalise::CONTRATADO->value)->count();

        $taxaAprovacao = $totalAnalises > 0
            ? round(($totalAprovadas / $totalAnalises) * 100, 1)
            : 0;

        $volumeSolicitado = (float) AnaliseCredito::sum('valor_solicitado');
        $volumeAprovado = (float) AnaliseCredito::whereIn('status', [
            StatusAnalise::APROVADO->value,
            StatusAnalise::PROCESSANDO_CONTRATACAO->value,
            StatusAnalise::CONTRATADO->value,
        ])->sum('valor_solicitado');
        $volumeContratado = (float) AnaliseCredito::where('status', StatusAnalise::CONTRATADO->value)->sum('valor_solicitado');

        $totalClientes = Cliente::count();

        $ultimasAnalises = AnaliseCredito::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        return [
            'total_solicitacoes'  => $totalAnalises,
            'total_aprovadas'     => $totalAprovadas,
            'total_reprovadas'    => $totalReprovadas,
            'total_contratadas'   => $totalContratadas,
            'taxa_aprovacao'      => $taxaAprovacao,
            'volume_solicitado'   => $volumeSolicitado,
            'volume_aprovado'     => $volumeAprovado,
            'volume_contratado'   => $volumeContratado,
            'total_clientes'      => $totalClientes,
            'ultimas_analises'    => $ultimasAnalises,
        ];
    }
}
