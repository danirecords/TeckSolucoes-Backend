<?php
namespace App\Services;

use App\Models\Processamento;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CnabGeneratorService
{
    private function padRight(string $s, int $len): string {
        return str_pad(mb_substr($s ?? '', 0, $len), $len, ' ');
    }

    private function padLeft(string $s, int $len, string $char = '0'): string {
        return str_pad(mb_substr($s ?? '', 0, $len), $len, $char, STR_PAD_LEFT);
    }

    public function generate(Processamento $p)
    {
        $fundo = $p->fundo;

        $nome       = $this->padRight($fundo->nome ?? '', 10);     // 10
        $cnpj       = $this->padRight(preg_replace('/\\D/','',$fundo->cnpj ?? ''), 14); // 14
        $logradouro = $this->padRight($fundo->logradouro ?? '', 10); // 10
        $numero     = $this->padLeft($fundo->numero ?? '0', 3);     // 3
        $sequencia  = $this->padLeft($p->sequencia_arquivo ?? '0', 3); // 3
        $header = $nome . $cnpj . $logradouro . $numero . $sequencia;

        if (mb_strlen($header) !== 40) {
            $header = mb_substr($header, 0, 40);
            $header = str_pad($header, 40, ' ');
        }

        $bodyLines = [];
        $sumCentavos = 0;
        $contracts = $p->contratos()->get();
        foreach ($contracts as $c) {
            $contrato = $this->padLeft((string)$c->contrato_numero, 6);
            $nomec = $this->padRight($c->cliente_nome ?? '', 20);
            $centavos = (int) round($c->valor * 100);
            $valor = $this->padLeft((string)$centavos, 6);
            $data = Carbon::parse($c->data_operacao)->format('Ymd'); // 8
            $line = $contrato . $nomec . $valor . $data;

            if (mb_strlen($line) !== 40) {
                $line = mb_substr($line, 0, 40);
                $line = str_pad($line, 40, ' ');
            }
            $bodyLines[] = $line;
            $sumCentavos += $centavos;
        }

        $somaField = $this->padLeft((string)$sumCentavos, 11);

        $banco   = $this->padLeft($p->banco_codigo ?? '341', 3);
        $agencia = $this->padLeft($p->agencia ?? '12345', 5);
        $conta   = $this->padLeft($p->conta ?? '987651', 7);
        $padding = str_repeat(' ', 14);
        $footer = $somaField . $banco . $agencia . $conta . $padding;
        if (mb_strlen($footer) !== 40) {
            $footer = mb_substr($footer, 0, 40);
            $footer = str_pad($footer, 40, ' ');
        }

        $content = $header . "\n" . implode("\n", $bodyLines) . "\n" . $footer . "\n";

        $path = 'cnabs/cnab_' . $p->id . '.txt';
        Storage::put($path, $content);

        return $path;
    }
}
