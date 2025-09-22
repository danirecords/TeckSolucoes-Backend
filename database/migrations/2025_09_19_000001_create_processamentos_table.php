<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessamentosTable extends Migration
{
    public function up()
    {
        Schema::create('processamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('original_filename');
            $table->foreignId('fundo_id')->constrained('fundos');
            $table->string('sequencia_arquivo', 10);
            $table->enum('status', ['pendente','processando','concluido','erro'])->default('pendente');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->text('error_message')->nullable();
            $table->string('excel_path')->nullable();
            $table->string('cnab_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('processamentos');
    }
}
