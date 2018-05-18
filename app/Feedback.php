<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $appends = ['likes', 'dislikes'];

    protected $fillable = ['texto', 'capitulo_id', 'user_id'];

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usersCurtiram()
    {
        return $this->belongsToMany(User::class, 'feedback_likes', 'feedback_id', 'user_id');
    }

    public function usersDescurtiram()
    {
        return $this->belongsToMany(User::class, 'feedback_dislikes', 'feedback_id', 'user_id');
    }

    public function getLikesAttribute()
    {
        return $this->usersCurtiram()->count();
    }

    public function getDislikesAttribute()
    {
        return $this->usersDescurtiram()->count();
    }
}
