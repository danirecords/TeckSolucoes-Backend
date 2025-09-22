<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fundo;
use App\Models\FundoDePara;

class FundosSeeder extends Seeder
{
    public function run()
    {
        $alpha = Fundo::create([
            'nome' => 'Fundo Alpha',
            'cnpj' => '12.345.678/0001-01',
            'razao_social' => 'Fundo de Investimentos Alpha',
            'logradouro' => 'Rua das Árvores',
            'numero' => '123'
        ]);

        $beta = Fundo::create([
            'nome' => 'Fundo Beta',
            'cnpj' => '98.765.432/0001-02',
            'razao_social' => 'Fundo Beta Capital',
            'logradouro' => 'Av. Brasil',
            'numero' => '456'
        ]);

        $gama = Fundo::create([
            'nome' => 'Fundo Gama',
            'cnpj' => '11.222.333/0001-03',
            'razao_social' => 'Gama Investimentos Financeiros',
            'logradouro' => 'Alameda Santos',
            'numero' => '789'
        ]);

        // Exemplos de De/Para (opcionais)
        $alpha->dePara()->createMany([
            ['chave'=>'end_num','valor'=>'123'], // exemplo
            ['chave'=>'cidade','valor'=>'São Paulo']
        ]);

        $beta->dePara()->createMany([
            ['chave'=>'end_num','valor'=>'456']
        ]);

        $gama->dePara()->createMany([
            ['chave'=>'end_num','valor'=>'789']
        ]);
    }
}
