<?php

namespace App;

use App\User;
use App\Obra;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $fillable = ['texto', 'obra_id', 'user_id'];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usersCurtiram()
    {
        return $this->belongsToMany(User::class, 'comentario_likes', 'comentario_id', 'user_id');
    }

    public function usersDescurtiram()
    {
        return $this->belongsToMany(User::class, 'comentario_dislikes', 'comentario_id', 'user_id');
    }
}
