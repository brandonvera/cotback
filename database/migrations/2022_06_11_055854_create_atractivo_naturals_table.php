<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtractivoNaturalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atractivo_naturals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->LongText('direccion')->nullable();
            $table->string('estado');
            $table->foreignId('usuario_creacion')
                  ->unsigned()
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('usuario_modificacion')
                  ->unsigned()
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('id_municipio')
                  ->unsigned()
                  ->nullable()
                  ->constrained('municipios')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atractivo_naturals');
    }
}
