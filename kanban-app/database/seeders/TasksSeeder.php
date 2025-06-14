<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Column;
use App\Models\User;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach (Column::all() as $column) {
            foreach ($users as $user) {
                Task::create([
                    'title' => "Tarefa de {$user->name} na coluna {$column->name}",
                    'description' => "Descrição da tarefa de {$user->name} na coluna {$column->name}",
                    'column_id' => $column->id,
                    'user_id' => $user->id,
                    'position' => 1,
                ]);
            }
        }
    }
}
