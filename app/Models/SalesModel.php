<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    protected $table = 'mst_sales';
    protected $primaryKey = 'sales_id';
    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sale_date' => 'datetime',
    ];

    protected $fillable = [
        'location',
        'customer_id',
        'sale_date',
        'invoice_no',
        'full_name',
        'mobile_no',
        'email',
        'id_no',
        'file_id',
        'id_proof',
        'bill_status',
        'sales_status',
        'discount',
        'gst_applicable',
        'gst_number',
        'gst_display',
        'tcs_display',
        'payment_split_amount',
        'remaining_amount',
        'finalTotal',
        'sale_status',
        'return_no',
        'return_date',
        'status',
        'created_by',
        'updated_by',
        'gst_amount',
        'tcs_percentage'
    ];

    public function products()
    {
        return $this->hasMany(
            SalesProductModel::class,
            'sales_id',
            'sales_id'
        )->with('product');
    }
}
