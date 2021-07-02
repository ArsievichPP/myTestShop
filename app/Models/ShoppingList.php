<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    public function order()
    {
        $this->hasOne(Order::class);
    }

    public function product()
    {
        $this->hasOne(Product::class);
    }

    public function create($orderId): bool
    {
        $idAndQuantity = session()->get('idAndQuantity');
        foreach ($idAndQuantity as $id => $quantity) {
            if (!$this->query()->insert(['order_id' => $orderId, 'product_id' => $id, 'quantity' => $quantity])) {
                return false;
            }
        }
        session()->forget('idAndQuantity');
        return true;
    }
}
