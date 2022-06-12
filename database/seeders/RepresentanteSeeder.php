<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Representante;

class RepresentanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('representantes')->insert([
            "nombre" => "brandon",
            "apellido" => "vera",
            "cargo" => "gerente",
            "telefono" => "04168724703",
            "correo" => "admin@gmail.com",
            "direccion" => "palo gordo, altos de paramillo, dulceria #3514",       
            "estado" => "ACTIVO",
            "usuario_creacion" => null,
            "usuario_modificacion" => null,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);
    }
}
