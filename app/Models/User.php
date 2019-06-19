<?php

namespace App\Models;

use Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject{

    public function getJWTIdentifier()
    {

        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {

        return [];
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Carts','user_id','id');
    }
}