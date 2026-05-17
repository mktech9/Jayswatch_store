<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items'; // change if your table name differs

    protected $primaryKey = 'oi_id';

    public $timestamps = true;

    protected $fillable = [

        'order_id',
        'user_id',
        'product_id',
        'tid',
        'merchant_id',
        'currency',

        'product_name',
        'quantity',
        'price',
        'total',

        'status',

        'created_by',
        'updated_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTING (Recommended)
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'quantity' => 'integer',
        'price'    => 'float',
        'total'    => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Order relationship
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
