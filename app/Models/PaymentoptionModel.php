<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentoptionModel extends Model
{
    // Table name
    protected $table = 'tbl_payment_option';
    protected $primaryKey = 'p_id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'payment',
        'status',
        'created_by',
        'updated_by',
    ];
}
