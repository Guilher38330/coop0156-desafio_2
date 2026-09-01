<?php

namespace App\Services;

use App\Exceptions\BureauIndisponivelException;
use App\Exceptions\BureauRespostaMalformadaException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class BureauService
{
    /**
     * Consulta o score de crédito de um CPF no Bureau externo.
     *
     * @param  string  $cpf  CPF com 11 dígitos numéricos
     * @return int  Score retornado pelo Bureau
     *
     * @throws BureauIndisponivelException      Quando o Bureau está fora do ar ou retorna erro
     * @throws BureauRespostaMalformadaException Quando a resposta não contém a chave 'score'
     */
    public function consultarScore(string $cpf): int
    {
        $url     = config('services.score_bureau.url') . '/' . $cpf;
        $timeout = config('services.score_bureau.timeout', 3);

        try {
            $response = Http::timeout($timeout)->get($url);
        } catch (ConnectionException $e) {
            throw new BureauIndisponivelException(
                'Falha na conexão com o Bureau de Crédito.',
                0,
                $e
            );
        }

        if ($response->failed()) {
            throw new BureauIndisponivelException(
                'O Bureau de Crédito retornou um erro (HTTP ' . $response->status() . ').'
            );
        }

        $data = $response->json();

        if (!isset($data['score'])) {
            throw new BureauRespostaMalformadaException(
                'A resposta do Bureau de Crédito não contém o score.'
            );
        }

        return (int) $data['score'];
    }
}
