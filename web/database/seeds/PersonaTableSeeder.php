<?php

use App\Persona;
use Illuminate\Database\Seeder;

class PersonaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Persona::create([
            'nombre' => 'asd',
            'rut' => '18.791.036-6',
            'telefono' => '63887303',
            'email' => 'mgn21@gmail.com'
        ]);

        Persona::create([
            'nombre' => 'asdf',
            'rut' => '16.311.926-9',
            'telefono' => '63887303',
            'email' => 'mgn211@gmail.com'
        ]);

        Persona::create([
            'nombre' => 'asdg',
            'rut' => '24.802.658-8',
            'telefono' => '63887303',
            'email' => 'mgn21111@gmail.com'
        ]);
    }
}
