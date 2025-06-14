<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Column;
use Illuminate\Database\Seeder;

class DefaultColumnsSeeder extends Seeder
{
    public function run()
    {
        $defaultColumns = [
            ['name' => 'To Do', 'position' => 1],
            ['name' => 'In Progress', 'position' => 2],
            ['name' => 'Awaiting Code Review', 'position' => 3],
            ['name' => 'In Code Review / Testing', 'position' => 4],
            ['name' => 'Done', 'position' => 5],
        ];

        // Cria as colunas para todos os boards existentes
        Board::all()->each(function ($board) use ($defaultColumns) {
            foreach ($defaultColumns as $columnData) {
                Column::create([
                    'name' => $columnData['name'],
                    'position' => $columnData['position'],
                    'board_id' => $board->id,
                ]);
            }
        });
    }
}
