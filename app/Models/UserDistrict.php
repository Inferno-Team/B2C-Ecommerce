<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDistrict extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','district_id','street_info'];
    

}
