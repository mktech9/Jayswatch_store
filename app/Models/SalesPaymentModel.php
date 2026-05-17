<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPaymentModel extends Model
{
    protected $table = 'sales_payment';

    protected $primaryKey = 'sp_id';

    public $timestamps = false; // Because you're using custom created_at / updated_at

    protected $fillable = [
        'sales_id',
        'payment_id',
        'transaction_no',
        'bank_acc',
        'card_no',
        'cheque_no',
        'recieved_amount',
        'remain_amount',
        'total_amount',
        'payment_date',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public function sale()
    {
        return $this->belongsTo(SalesModel::class, 'sales_id');
    }
}
