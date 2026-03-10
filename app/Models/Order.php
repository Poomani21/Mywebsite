<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
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
        'canceled_device',
        'order_number'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', '_id');
    }

    public static function generateOrderNumber()
    {
        do {

            $orderNumber = 'OD-' . date('ymd') . '-' . strtoupper(Str::random(6));

        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

}
