<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Restaurant extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $casts = [
        'area' => 'array',
        'area_ar'=> 'array'
    ];

    protected $fillable = ['name','name_ar', 'main_image','thumbnail_image', 'review', 'review_ar','location', 'location_ar','area','area_ar','status','route','route_ar','value','cost','food_id'];


    // public function getFullSrcAttribute()  {
    //     return asset('storage/'.$this->image);

    // }0000000000000000000000000000000000000000000000000000


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
