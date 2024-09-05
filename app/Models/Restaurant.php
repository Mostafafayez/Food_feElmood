<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Restaurant extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'main_image', 'review', 'location', 'food_type', 'status','route','cost','food_id'];





    public function foodType()
    {
        return $this->belongsTo(SpinerFood::class, 'food_id');
    }
    public function images()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    public function urls()
    {
        return $this->hasOne(RestaurantUrl::class);
    }

    public function menus()
    {
        return $this->hasMany(RestaurantMenu::class);
    }

    public function phoneNumbers()
    {
        return $this->hasMany(RestaurantPhoneNumber::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function weeklySchedule()
    {
        return $this->hasOne(WeeklySchedule::class);
    }

    public function visitorActions()
    {
        return $this->hasMany(VisitorAction::class, 'restaurant_id');
    }
}
