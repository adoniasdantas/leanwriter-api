<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{

    public $fillable = ['titulo', 'descricao', 'user_id'];

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function capitulos()
    {
        return $this->hasMany(Capitulo::class, 'obra_id');
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'obra_categoria', 'obra_id', 'categoria_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function usersCurtiram()
    {
        return $this->belongsToMany(User::class, 'obra_likes', 'obra_id', 'user_id');
    }

    public function usersDescurtiram()
    {
        return $this->belongsToMany(User::class, 'obra_dislikes', 'obra_id', 'user_id');
    }

}
