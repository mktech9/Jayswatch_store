<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingFollowupModel extends Model
{

    protected $table = 'tbl_trading_followup';

    protected $primaryKey = 'trading_r_id';

    public $timestamps = false;

    protected $fillable = [
        'trading_id',
        'remark',
        'created_at',
        'created_by',
        'status',
        'updated_at',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
