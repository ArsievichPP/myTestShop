<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'customer_id',
            'delivery',
            'total_price',
        ];

    public $timestamps = false;

    public function shoppingLists(): HasMany
    {
        return $this->hasMany(ShoppingList::class);
    }

    public function deliveryMethod(): HasOne
    {
        return $this->hasOne(DeliveryMethod::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'customer_id');
    }

    public function payment(): HasOne
    {
       return $this->hasOne(Payment::class, 'id', 'payment_id');
    }

}
