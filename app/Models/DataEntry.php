<?php

namespace App\Models;

use Illuminate\Foundation\Auth\Users as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class DataEntry extends Authenticatable
{


    public $timestamps = false;
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
