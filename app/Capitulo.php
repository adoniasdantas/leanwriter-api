<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    protected $fillable = ['obra_id', 'titulo', 'texto'];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function usersCurtiram()
    {
        return $this->belongsToMany(User::class, 'capitulo_likes', 'capitulo_id', 'user_id');
    }

    public function usersDescurtiram()
    {
        return $this->belongsToMany(User::class, 'capitulo_dislikes', 'capitulo_id', 'user_id');
    }
}
