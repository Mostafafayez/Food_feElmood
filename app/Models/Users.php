<?php

namespace App\Models;

use Illuminate\Foundation\Auth\Users as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Auth\Middleware\Authenticate;

class Users extends Authenticatable
{
    use HasApiTokens, Notifiable;
public $timestamps =false;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        // 'remember_token',
    ];
}
