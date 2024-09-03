<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantUrl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'restaurant_id',
        'facebook_url',
        'youtube_url',
        'twitter_url',
        'whatsapp_url',
        'instagram_url',
        'tiktok_url'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
