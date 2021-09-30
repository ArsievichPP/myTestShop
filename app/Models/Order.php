<?php

namespace App\Models;

use App\Events\OrderCreatingEvent;
use App\Listeners\OrderCreatingListener;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    protected $statuses = [
        'Awaiting payment',
        'Payment accepted',
        'Processing in progress',
        'Ready for delivery',
        'Shipped',
        'Delivered',
        'Completed',
        'Canceled',
    ];

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
        return $this->hasOne(User::class);
    }

    public function assignStatusAwaitingPayment(){
        $this->status = $this->statuses[0];
    }
}
