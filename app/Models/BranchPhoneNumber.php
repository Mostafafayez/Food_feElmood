<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchPhoneNumber extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['branch_id', 'phone_number'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
