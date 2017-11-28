<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = ['texto', 'capitulo_id', 'user_id'];

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }
}
