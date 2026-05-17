<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quicksale_payment extends Model
{
    protected $table = 'quicksale_payment'; // exact table name

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [

        'quicksale_id',
        'split_chq_card',
        'split_type',
        'split_Date',
        'split_bank',
        'split_amt',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTING
    |--------------------------------------------------------------------------
    */
    // protected $casts = [
    //     'split_amt'  => 'float',
    //     'split_Date' => 'datetime',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];

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
