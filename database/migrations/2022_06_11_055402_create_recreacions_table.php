<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecreacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recreacions', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social')->unique();
            $table->bigInteger('establecimientos')
                  ->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->LongText('direccion_principal')->nullable();
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
            $table->foreignId('id_representantes')
                  ->unsigned()
                  ->nullable()
                  ->constrained('representantes')
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
        Schema::dropIfExists('recreacions');
    }
}
