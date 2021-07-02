<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public function shoppingLists(): HasMany
    {
        return $this->hasMany(ShoppingList::class);
    }

    public function deliveryMethod(): HasOne
    {
        return $this->hasOne(DeliveryMethod::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

}
