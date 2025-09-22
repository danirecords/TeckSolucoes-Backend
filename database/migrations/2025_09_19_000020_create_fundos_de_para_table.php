<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundosDeParaTable extends Migration
{
    public function up()
    {
        Schema::create('fundos_de_para', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundo_id')->constrained('fundos')->onDelete('cascade');
            $table->string('chave');
            $table->string('valor');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fundos_de_para');
    }
}
