<?php

namespace App\Jobs;

use App\Enums\StatusAnalise;
use App\Models\AnaliseCredito;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessarContratacaoJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $analiseId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $analise = AnaliseCredito::find($this->analiseId);

        if ($analise) {
            /**
             * Atualiza o status definitivo para contratado.
             */
            $analise->update(['status' => StatusAnalise::CONTRATADO]);

            /**
             * Registra log estruturado de auditoria do processamento.
             */
            Log::info("Contratação processada com sucesso via Fila.", [
                'analise_id' => $analise->id,
                'cliente_id' => $analise->cliente_id,
                'cpf'        => $analise->cpf,
            ]);
        }
    }
}
