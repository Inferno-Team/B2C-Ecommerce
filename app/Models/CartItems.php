<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id',
        'prod_id',
        'item_count'
    ];
    public function product(){
        return $this->hasOne(Product::class,'prod_id');
    }
}
