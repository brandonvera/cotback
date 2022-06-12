<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([TipoUsuarioSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([MunicipioSeeder::class]);
        $this->call([RepresentanteSeeder::class]);
        $this->call([HospedajeSeeder::class]);
        $this->call([AlimentoSeeder::class]);
        $this->call([TransporteSeeder::class]);
        $this->call([RecreacionSeeder::class]);
        $this->call([AtractivoCulturalSeeder::class]);
        $this->call([AtractivoNaturalSeeder::class]);
    }
}
