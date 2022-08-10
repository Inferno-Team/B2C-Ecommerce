<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billitem extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
        'prod_id',
        'item_count'
    ];
    public function product(){
        return $this->belongsTo(Product::class,'prod_id');
    }
}
