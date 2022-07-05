<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "nombre" => "Brandon",
            "apellido" => "Vera",
            "email" => "admin@gmail.com",
            "password" => Hash::make('Usuar10#'),
            "estado" => "ACTIVO",
            "usuario_creacion" => null,
            "usuario_modificacion" => null,
            "id_tipo" => 1,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);

        DB::table('users')->insert([
            "nombre" => "Usuario",
            "apellido" => "Prueba",
            "email" => "admin1@gmail.com",
            "password" => Hash::make('Usuar10#'),
            "estado" => "ACTIVO",
            "usuario_creacion" => 1,
            "usuario_modificacion" => 1,
            "id_tipo" => 2,
            "created_at" => date('Y-m-d H:m:s'),
            "updated_at" => date('Y-m-d H:m:s'),
        ]);
    }
}
