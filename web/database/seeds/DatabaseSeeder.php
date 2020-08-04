<?php

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
        $this->call([
        ComunidadTableSeeder::class,
        PersonaTableSeeder::class,
        PropiedadTableSeeder::class,
        VisitaTableSeeder::class,
        UsersTableSeeder::class,
        ]);


    }
}
