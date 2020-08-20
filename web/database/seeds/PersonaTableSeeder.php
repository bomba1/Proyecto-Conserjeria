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
            'telefono' => '963887303',
            'email' => 'hola@gmail.com'
        ]);

        Persona::create([
            'nombre' => 'asdf',
            'rut' => '16.311.926-9',
            'telefono' => '963887303',
            'email' => 'test@gmail.com'
        ]);

        Persona::create([
            'nombre' => 'asdg',
            'rut' => '24.802.658-8',
            'telefono' => '963887303',
            'email' => 'test2@gmail.com'
        ]);
    }
}
