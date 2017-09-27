<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nome'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'obra_categoria', 'categoria_id', 'obra_id');
    }
}
