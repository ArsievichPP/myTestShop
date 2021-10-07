<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    public $fillable = [
        'method',
        'payment_id',
        'paid_status',
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'payment_id', 'id');
    }
}
