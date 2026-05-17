<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProductModel extends Model
{
    protected $table = 'mst_sales_product';
    protected $primaryKey = 'sales_product_id';
    public $timestamps = true;

    protected $fillable = [
        'sales_id',
        'product_id',
        'description',
        'hsn_code',
        'qty',
        'mrp',
        'sales_price',
        'status'
    ];

    protected $casts = [
        'sales_price' => 'float',
        'qty' => 'int'
    ];

    public function product()
    {
        return $this->belongsTo(
            ProductModel::class,
            'product_id', // FK in mst_sales_product
            'pro_id'      // PK in mst_product
        );
    }
}