<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    protected $fillable = ['obra_id', 'numero', 'titulo', 'texto'];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
