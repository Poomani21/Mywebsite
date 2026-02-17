<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'userID',
        'paypal_order_id',
        'items',
        'total_amount',
        'status',
        'shipping_address',
        'stripe_payment_id',
        'stripe_payment_intent_id',
        'ordered_device',
        'canceled_device'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', '_id');
    }

}
