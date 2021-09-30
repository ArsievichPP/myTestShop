<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'order_id',
            'product_id',
            'quantity',
            'unit_price',
        ];

    public $timestamps = false;

    public function order()
    {
        $this->hasOne(Order::class);
    }

    public function product()
    {
        $this->hasOne(Product::class);
    }
}
