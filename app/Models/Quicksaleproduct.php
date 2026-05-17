<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quicksaleproduct extends Model
{
    protected $table = 'quicksaleproduct';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [

        'quicksale_id',
        'qty',
        'product_name',
        'description',
        'hsn_code',
        'per_total_price',
        'updated_date'
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTING (Recommended)
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'qty'             => 'integer',
        'per_total_price' => 'float',
        'updated_date'    => 'datetime',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Belongs to QuickSale
    public function quicksale()
    {
        return $this->belongsTo(QuickSale::class, 'quicksale_id', 'id');
    }
}
