<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position', 'board_id'];

    /**
     * Uma Column pertence a um Board
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Uma Column pode ter várias Tasks
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
