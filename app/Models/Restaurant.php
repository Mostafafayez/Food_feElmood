<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Restaurant extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'main_image', 'review', 'location', 'food_type', 'status','route'];

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
}
