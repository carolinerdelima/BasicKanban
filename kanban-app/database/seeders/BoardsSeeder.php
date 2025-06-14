<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Seeder;

class BoardsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Board::create([
                'name' => "Kanban de {$user->name}",
                'user_id' => $user->id,
            ]);
        }
    }
}
