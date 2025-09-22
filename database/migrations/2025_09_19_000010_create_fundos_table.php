<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundosTable extends Migration
{
    public function up()
    {
        Schema::create('fundos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cnpj')->nullable();
            $table->string('razao_social')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fundos');
    }
}
