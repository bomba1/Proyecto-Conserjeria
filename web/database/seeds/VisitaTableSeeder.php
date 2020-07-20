<?php

use App\Visita;
use Illuminate\Database\Seeder;

class VisitaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visita::create([
            'fecha' => '2018-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2019-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2020-12-31 13:05:21',
            'parentesco' => 'empresa',
            'empresa_reparto' => 'SI',
            'persona_id' => 2,
            'propiedad_id' => 3
        ]);

        Visita::create([
            'fecha' => '2019-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2017-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2015-12-31 13:05:21',
            'parentesco' => 'empresa',
            'empresa_reparto' => 'SI',
            'persona_id' => 2,
            'propiedad_id' => 3
        ]);
    }
}
