<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kanban.com',
            'password' => Hash::make('dev1206'),
        ]);

        User::create([
            'name' => 'Dev',
            'email' => 'dev@kanban.com',
            'password' => Hash::make('dev1206'),
        ]);

        User::create([
            'name' => 'Caroline Lima',
            'email' => 'carolinelima013@hotmail.com',
            'password' => Hash::make('dev1206'),
        ]);
    }
}
