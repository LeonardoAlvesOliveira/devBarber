<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Stmt\Return_;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getkey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
