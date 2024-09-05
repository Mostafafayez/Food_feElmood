<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinerFood extends Model
{
    use HasFactory;
    public $timestamps = false;
    // Specify the table name if it's different from the plural form of the model name
    protected $table = 'spiner_food';


    protected $fillable = ['food_type', 'priority','status'];





    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'food_id');
    }
}
