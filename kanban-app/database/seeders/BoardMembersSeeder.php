<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Seeder;

class BoardMembersSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach (Board::all() as $board) {
            $board->users()->attach($users->pluck('id')->toArray());
        }
    }
}
