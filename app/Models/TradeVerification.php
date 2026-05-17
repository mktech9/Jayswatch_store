<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeVerification extends Model
{
    protected $table = "tbl_trade_verification";

    protected $fillable = [
        'phone',
        'otp',
        'is_verified'
    ];

    public $timestamps = false;
}
