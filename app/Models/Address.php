<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;


class Address extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'address';


    protected $fillable = [
        'userID',
        'name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',
        'is_default',
    ];

    // Relation: Address belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
