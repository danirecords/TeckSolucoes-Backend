<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Processamento;
use App\Jobs\ProcessCNABJob;

class ProcessamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Processamento::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled(['from','to'])) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function downloadExcel($id)
    {
        $proc = Processamento::findOrFail($id);

        if (!$proc->arquivo_excel) {
            return response()->json(['error' => 'Arquivo não encontrado'], 404);
        }

        return response()->download(storage_path('app/' . $proc->arquivo_excel));
    }

    public function downloadCnab($id)
    {
        $proc = Processamento::findOrFail($id);

        if (!$proc->arquivo_cnab) {
            return response()->json(['error' => 'CNAB não gerado'], 404);
        }

        return response()->download(storage_path('app/' . $proc->arquivo_cnab));
    }

}
