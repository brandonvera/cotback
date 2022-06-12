<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AtractivoCulturals;

class AtractivoCulturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('atractivo_culturals')->insert([
            "nombre" => "Monumento al trompo",
            "direccion" => "palo gordo, altos de paramillo, dulceria #3514",
            "estado" => "ACTIVO",
            "usuario_creacion" => null,
            "usuario_modificacion" => null,
            "id_municipio" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);
    }
}
