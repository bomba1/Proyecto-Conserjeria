<?php

use App\Comunidad;
use Illuminate\Database\Seeder;

class ComunidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comunidad::create([
            'nombre' => 'condominio 1',
            'direccion' => 'direccion 1',
            'tipo' => 'CONDOMINIO'
        ]);

        Comunidad::create([
            'nombre' => 'condominio 2',
            'direccion' => 'direccion 2',
            'tipo' => 'CONDOMINIO'
        ]);

        Comunidad::create([
            'nombre' => 'edificio 1',
            'direccion' => 'direccion 3',
            'tipo' => 'EDIFICIO'
        ]);
    }
}
