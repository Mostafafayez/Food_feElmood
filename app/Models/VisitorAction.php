<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorAction extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'action',
        'restaurant_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
