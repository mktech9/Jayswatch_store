<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingModel extends Model
{

    protected $table = 'tbl_trading';


    protected $primaryKey = 'trading_id';


    public $timestamps = true;


    protected $fillable = [
        'trading_brand_id',
        'treading_model_no',
        'price',
        'images',
        'looking_brand_id',
        'looking_model_no',
        'comments',
        'name',
        'email_id',
        'contact_no',
        'purchase_from',
        'country',
        'state',
        'city',
        'created_at',
        'created_by',
        'status'

    ];

    public function brandInfo()
    {
        return $this->belongsTo(BrandModel::class, 'trading_brand_id', 'brand_id');
    }

    public function brand()
    {
        return $this->belongsTo(BrandModel::class, 'looking_brand_id', 'brand_id');
    }
}
