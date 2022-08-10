<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_disc_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userDistrict()
    {
        return $this->belongsTo(UserDistrict::class,'user_disc_id');
    }
    public function billItems()
    {
        return $this->hasMany(Billitem::class,'bill_id','id');
    }
    
}
