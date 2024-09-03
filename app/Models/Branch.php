<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['restaurant_id', 'location'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function phoneNumbers()
    {
        return $this->hasMany(BranchPhoneNumber::class);
    }
}
