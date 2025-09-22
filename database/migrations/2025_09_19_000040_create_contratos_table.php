<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processamento_id')->constrained('processamentos')->onDelete('cascade');
            $table->string('contrato_numero');
            $table->string('cliente_nome');
            $table->decimal('valor', 15, 2);
            $table->date('data_operacao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contratos');
    }
}
