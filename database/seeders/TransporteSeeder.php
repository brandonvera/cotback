<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Transporte;

class TransporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transportes')->insert([
            "razon_social" => "McDonald",
            "establecimientos" => 1,
            "telefono" => "04140000100",
            "correo" => "admin@gmail.com",
            "direccion_principal" => "palo gordo, altos de paramillo, dulceria #3514",
            "estado" => "ACTIVO",
            "usuario_creacion" => null,
            "usuario_modificacion" => null,
            "id_municipio" => 1,
            "id_representantes" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);
    }
}
