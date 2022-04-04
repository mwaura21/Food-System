<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'vendor', 
        'name', 
        'order_id', 
        'picture', 
        'customer', 
        'first_name', 
        'last_name', 
        'email', 
        'phone_number', 
        'address', 
        'county', 
        'payment', 
        'quantity', 
        'one_total', 
        'total', 
    ];

    public function ordervendor()
    {

        return $this->hasMany(Vendor::class);

    }
}
