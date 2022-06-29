<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Municipio;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('municipios')->insert([
            "nombre" => "San Cristobal",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Cardenas",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Cordoba",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Jauregui",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Lobatera",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Fernandez Feo",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Garcia de Hevia",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Junin",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Uribante",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('municipios')->insert([
            "nombre" => "Francisco de Miranda",
            "estado" => "ACTIVO",           
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);
    }
}
