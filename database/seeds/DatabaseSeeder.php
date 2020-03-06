<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@cremacionmascotas.com',
            'password' => Hash::make('admin'),
            'role' => 2
        ]);
        User::create([
            'name' => 'Usuario',
            'email' => 'usuario@cremacionmascotas.com',
            'password' => Hash::make('usuario'),
            'role' => 1
        ]);
    }
}
