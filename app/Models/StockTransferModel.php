<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransferModel extends Model
{
    protected $table = 'mst_stock_trasfer';

    protected $primaryKey = 'stock_id';

    public $timestamps = false;

    protected $fillable = [
        'transfer_date',
        'reference_no',
        'stock_status',
        'location_from',
        'location_to',
        'shipping_charges',
        'notes',
        'total',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function fromLocation()
    {
        return $this->belongsTo(
            BusinesslocationModel::class,
            'location_from',
            'bl_id'
        );
    }

    public function toLocation()
    {
        return $this->belongsTo(
            BusinesslocationModel::class,
            'location_to',
            'bl_id'
        );
    }

}
