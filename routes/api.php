<?php

use App\Http\Controllers\AnaliseCreditoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MockBureauController;
use Illuminate\Support\Facades\Route;

/**
 * Rotas de CRUD de Clientes e Histórico de Análises do Cooperado.
 */
Route::get('/clientes/{id}/analises', [ClienteController::class, 'analises']);
Route::apiResource('clientes', ClienteController::class);

/**
 * Rotas de Solicitação, Listagem e Contratação de Análise de Crédito.
 */
Route::get('/analises-credito', [AnaliseCreditoController::class, 'index']);
Route::post('/analise-credito', [AnaliseCreditoController::class, 'solicitar'])
    ->middleware('throttle:analise-credito');
Route::post('/analise-credito/{id}/contratar', [AnaliseCreditoController::class, 'contratar']);

/**
 * Rota de Indicadores e Métricas Consolidadas do Dashboard.
 */
Route::get('/dashboard/metricas', [DashboardController::class, 'metricas']);

/**
 * Endpoint de Mock (Bureau de Crédito externo simulado).
 */
Route::get('/mock/bureau/{cpf}', [MockBureauController::class, 'consultar']);
