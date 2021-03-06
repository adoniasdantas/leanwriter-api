<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();
        return $this->api_token;
    }

    public function obras()
    {
        return $this->hasMany(Obra::class);
    }

    public function obrasCurtidas()
    {
        return $this->belongsToMany(Obra::class, 'obra_likes', 'user_id', 'obra_id');
    }

    public function obrasDescurtidas()
    {
        return $this->belongsToMany(Obra::class, 'obra_dislikes', 'user_id', 'obra_id');
    }

}
