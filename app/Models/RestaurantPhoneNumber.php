<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantPhoneNumber extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['restaurant_id', 'phone_number'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
