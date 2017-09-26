<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{

    public $fillable = ['titulo', 'descricao', 'user_id'];

    public function autor()
    {
        return $this->belongsTo(User::class);
    }

    public function capitulos()
    {
        return $this->hasMany(Capitulo::class, 'obra_id');
    }
}
