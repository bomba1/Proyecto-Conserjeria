<?php

use App\Propiedad;
use Illuminate\Database\Seeder;

class PropiedadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Propiedad::create([
            'numero' => 100,
            'tipo' => 'CASA',
            'comunidad_id' => 1
        ]);

        Propiedad::create([
            'numero' => 101,
            'tipo' => 'CASA',
            'comunidad_id' => 1
        ]);

        Propiedad::create([
            'numero' => 201,
            'tipo' => 'DEPARTAMENTO',
            'comunidad_id' => 3
        ]);
        Propiedad::create([
            'numero' => 202,
            'tipo' => 'DEPARTAMENTO',
            'comunidad_id' => 3
        ]);
    }
}
