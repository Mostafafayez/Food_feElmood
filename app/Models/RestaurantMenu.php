<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['restaurant_id', 'menu_image'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
