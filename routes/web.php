<?php

use App\Http\Controllers\SimulacaoController;
use Illuminate\Support\Facades\Route;

/**
 * Interface de Solicitação de Análise de Crédito.
 */
Route::get('/', function () {
    return view('analise');
});

/**
 * Interface de Gestão de Cooperados (Clientes).
 */
Route::get('/clientes', function () {
    return view('clientes');
});

/**
 * Interface de Dashboard & Histórico de Análises.
 */
Route::get('/analises', function () {
    return view('analises');
});

/**
 * Interface de Visualização da Simulação e Contratação.
 */
Route::get('/simulacao/{id}', [SimulacaoController::class, 'show']);
