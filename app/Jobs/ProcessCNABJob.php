<?php

namespace App\Jobs;

use App\Models\Processamento;
use App\Services\CNABService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCNABJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Processamento $processamento;

    public function __construct(Processamento $processamento)
    {
        $this->processamento = $processamento;
    }

    public function handle(CNABService $service)
    {
        $this->processamento->update(['status' => 'processando']);
        try {
            $cnabFile = $service->gerarCNAB($this->processamento);

            $this->processamento->update([
                'status' => 'concluido',
                'arquivo_cnab' => $cnabFile
            ]);
        } catch (\Exception $e) {
            $this->processamento->update(['status' => 'erro']);
        }
    }
}
