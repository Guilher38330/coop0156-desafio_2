<?php

namespace App\Services;

use App\Enums\StatusAnalise;
use App\Models\AnaliseCredito;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class AnaliseCreditoService
{
    /** Renda mensal mínima para aprovação */
    private const RENDA_MINIMA = 1500.00;

    /** Score mínimo para aprovação */
    private const SCORE_MINIMO = 400;

    /** Score a partir do qual a taxa menor é aplicada */
    private const SCORE_ALTO = 700;

    /** Taxa de juros ao mês para score entre 400 e 699 */
    private const TAXA_SCORE_MEDIO = 4.5;

    /** Taxa de juros ao mês para score >= 700 */
    private const TAXA_SCORE_ALTO = 2.9;

    /** Número fixo de parcelas */
    private const PARCELAS = 12;

    /** Percentual máximo de comprometimento da renda */
    private const COMPROMETIMENTO_MAXIMO = 0.30;

    public function __construct(
        private readonly BureauService $bureauService
    ) {}

    /**
     * Solicita uma nova análise de crédito.
     *
     * Fluxo:
     *  1. Localiza ou cria o cliente (DB::transaction).
     *  2. Persiste a análise como pendente (DB::transaction).
     *  3. Verifica renda mínima (antes de consultar Bureau).
     *  4. Consulta o Bureau de Crédito.
     *  5. Aplica regras de elegibilidade (score, parcela, comprometimento).
     *  6. Atualiza a análise com o resultado.
     *
     * @param  array  $dados  Dados validados do request
     * @return AnaliseCredito
     *
     * @throws \App\Exceptions\BureauIndisponivelException
     * @throws \App\Exceptions\BureauRespostaMalformadaException
     */
    public function solicitar(array $dados): AnaliseCredito
    {
        $rendaMensal     = (float) $dados['renda_mensal'];
        $valorSolicitado = (float) $dados['valor_solicitado'];

        // 1. Transação: localizar/criar cliente + criar análise pendente
        [$cliente, $analise] = DB::transaction(function () use ($dados) {
            $cliente = Cliente::firstOrCreate(
                ['cpf' => $dados['cpf']],
                [
                    'nome'         => $dados['nome'],
                    'renda_mensal' => $dados['renda_mensal'],
                    'email'        => $dados['cpf'] . '@coop0156.local',
                ]
            );

            $analise = AnaliseCredito::create([
                'cliente_id'       => $cliente->id,
                'cpf'              => $dados['cpf'],
                'nome'             => $dados['nome'],
                'renda_mensal'     => $dados['renda_mensal'],
                'tipo_credito'     => $dados['tipo_credito'],
                'valor_solicitado' => $dados['valor_solicitado'],
                'status'           => StatusAnalise::PENDENTE,
            ]);

            return [$cliente, $analise];
        });

        // 2. Verificar renda mínima (antes de chamar Bureau para economizar a chamada)
        if ($rendaMensal < self::RENDA_MINIMA) {
            return $this->reprovar($analise, null, 'Renda mínima insuficiente');
        }

        // 3. Consultar Bureau de Crédito (pode lançar exceção — tratada no Controller)
        $score = $this->bureauService->consultarScore($dados['cpf']);

        // 4. Verificar score mínimo
        if ($score < self::SCORE_MINIMO) {
            return $this->reprovar($analise, $score, 'Score de crédito muito baixo');
        }

        // 5. Determinar taxa de juros com base na faixa de score
        $taxa = $score >= self::SCORE_ALTO
            ? self::TAXA_SCORE_ALTO
            : self::TAXA_SCORE_MEDIO;

        // 6. Calcular parcela com arredondamento financeiro
        $jurosTotais = round($valorSolicitado * ($taxa / 100) * self::PARCELAS, 2);
        $valorTotal  = round($valorSolicitado + $jurosTotais, 2);
        $parcela     = round($valorTotal / self::PARCELAS, 2);

        // 7. Verificar comprometimento de renda (parcela > 30% da renda)
        $limiteRenda = round($rendaMensal * self::COMPROMETIMENTO_MAXIMO, 2);

        if ($parcela > $limiteRenda) {
            return $this->reprovar($analise, $score, 'Comprometimento de renda superior a 30%', $taxa, $parcela);
        }

        // 8. Aprovar
        $analise->update([
            'status'       => StatusAnalise::APROVADO,
            'score'        => $score,
            'taxa_juros'   => $taxa,
            'valor_parcela' => $parcela,
        ]);

        return $analise;
    }

    /**
     * Confirma a contratação de uma análise aprovada.
     *
     * @param  int  $id  ID da análise
     * @return AnaliseCredito
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \InvalidArgumentException  Quando a análise não está aprovada
     */
    public function contratar(int $id): AnaliseCredito
    {
        $analise = AnaliseCredito::findOrFail($id);

        if ($analise->status !== StatusAnalise::APROVADO) {
            throw new \InvalidArgumentException(
                'Apenas análises com status aprovado podem ser contratadas.'
            );
        }

        $analise->update(['status' => StatusAnalise::CONTRATADO]);

        return $analise;
    }

    /**
     * Atualiza a análise com status de reprovação.
     *
     * @param  AnaliseCredito  $analise
     * @param  int|null        $score
     * @param  string          $motivo
     * @param  float|null      $taxa
     * @param  float|null      $parcela
     * @return AnaliseCredito
     */
    private function reprovar(
        AnaliseCredito $analise,
        ?int $score,
        string $motivo,
        ?float $taxa = null,
        ?float $parcela = null,
    ): AnaliseCredito {
        $dados = [
            'status'          => StatusAnalise::REPROVADO,
            'motivo_rejeicao' => $motivo,
        ];

        if ($score !== null) {
            $dados['score'] = $score;
        }

        if ($taxa !== null) {
            $dados['taxa_juros'] = $taxa;
        }

        if ($parcela !== null) {
            $dados['valor_parcela'] = $parcela;
        }

        $analise->update($dados);

        return $analise;
    }
}
