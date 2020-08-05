<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Miguel Leon',
            'email' => 'migand21@gmail.com',
            'password' => bcrypt('miguel12345')
        ]);

        User::create([
            'name' => 'Ignacio Santander',
            'email' => 'ignaciosantanderq13@gmail.com',
            'password' => bcrypt('ignacio12345')
        ]);
    }
}
