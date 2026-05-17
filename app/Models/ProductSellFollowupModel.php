<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSellFollowupModel extends Model
{

    protected $table = 'tbl_sell_followup';

    protected $primaryKey = 'sell_r_id';

    public $timestamps = false;

    protected $fillable = [
        'selling_id',
        'remark',
        'created_at',
        'created_by',
        'status',
        'updated_at',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime', // 🔥 THIS IS THE FIX
    ];

    public function getCreatedAtAttribute()
    {
        return $this->attributes['craeted_at'] ?? null;
    }
}
