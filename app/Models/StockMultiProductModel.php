<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMultiProductModel extends Model
{
    protected $table = 'stock_multi_product';

    protected $primaryKey = 'stock_multi_id';

    public $timestamps = false;

    protected $fillable = [
        'stock_id',
        'product_id',
        'qyt',
        'unit_price',
        'unit_type',
        'status',
        'created_by',
        'updated_by',
        'updated_at',
        'created_at'
    ];

public function product()
{
    return $this->belongsTo(ProductModel::class, 'product_id', 'pro_id');
}

}
