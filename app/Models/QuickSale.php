<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickSale extends Model
{
    protected $table = 'quicksale';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [

        'business_id',
        'location_id',
        'invoice_num',

        'fullname',
        'mobile_num',
        'email',
        'state',
        'pincode',

        'id_proof_type',
        'id_proof_file',
        'id_numbers',

        'bill_status',
        'bill_date',

        'gsttype',
        'gst',
        'tcs',
        'gstnum',

        'net_amount',
        'return_amt',
        'return_tax',
        'total_qty',
        'discount',
        'finaltotal',

        'chq_card',
        'type',
        'Date',
        'bank',
        'compare_date'
    ];


public function quicksaleproduct()
{
    return $this->hasMany(
        Quicksaleproduct::class,
        'quicksale_id', // foreign key in quicksaleproduct table
        'id'            // primary key in quicksale table
    );
}


    public function quicksale_payment()
    {
        return $this->hasMany(Quicksale_payment::class,
        'quicksale_id', // foreign key in quicksaleproduct table
        'id');
    }


    /*
    |--------------------------------------------------------------------------
    | CASTING (Recommended)
    |--------------------------------------------------------------------------
    */
    // protected $casts = [
    //     'bill_date'    => 'datetime',
    //     'Date'         => 'datetime',
    //     'compare_date' => 'datetime',

    //     'net_amount' => 'float',
    //     'return_amt' => 'float',
    //     'return_tax' => 'float',
    //     'discount'   => 'float',
    //     'finaltotal' => 'float',
    //     'gst'        => 'float',
    //     'tcs'        => 'float',
    // ];
}
