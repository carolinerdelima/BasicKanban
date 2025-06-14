<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    /**
     * Um Board pertence a um usuário (dono do quadro)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um Board pode ter várias Columns (To Do, In Progress, etc)
     */
    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    /**
     * Um Board pode ser acessado por vários usuários
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
