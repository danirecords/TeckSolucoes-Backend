<?php

namespace App\Services;

use App\Models\Processamento;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class CNABService
{

    public function gerarCNAB(Processamento $processamento): string
    {
        $spreadsheet = IOFactory::load(storage_path('app/' . $processamento->arquivo));
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $lines = [];

        $lines[] = str_pad($processamento->fundo, 10) . str_pad($processamento->sequencia, 30);

        foreach ($rows as $row) {
            if (empty($row['A'])) continue;
            $contrato = str_pad($row['A'], 6, '0', STR_PAD_LEFT);
            $cliente = str_pad($row['B'], 22);
            $valor = str_pad((int)($row['C'] * 100), 6, '0', STR_PAD_LEFT);
            $data = date('Ymd', strtotime($row['D']));

            $lines[] = $contrato . $cliente . $valor . $data;
        }

        $filename = 'cnabs/' . uniqid() . '.txt';
        Storage::put($filename, implode("\n", $lines));

        return $filename;
    }
}
