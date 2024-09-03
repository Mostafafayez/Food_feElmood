<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklySchedule extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'restaurant_id',
        'saturday_opening_time',
        'saturday_closing_time',
        'sunday_opening_time',
        'sunday_closing_time',
        'monday_opening_time',
        'monday_closing_time',
        'tuesday_opening_time',
        'tuesday_closing_time',
        'wednesday_opening_time',
        'wednesday_closing_time',
        'thursday_opening_time',
        'thursday_closing_time'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
