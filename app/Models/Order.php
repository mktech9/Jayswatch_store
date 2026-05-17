<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $primaryKey = 'o_id';

    public $timestamps = true;

    protected $fillable = [

        'order_id',
        'invoice_num',
        'payment_method',
        'product_id',
        'user_id',
        'shipping_email',
        'shipping_phone',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_citizen_type',
        'doc_file',
        'pan_no',
        'pan_json',
        'shipping_address',
        'shipping_landmark',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'same_as_billing',
        'billing_first_name',
        'billing_last_name',
        'billing_phone',
        'billing_address',
        'billing_landmark',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'subtotal',
        'tcs',
        'tax',
        'total',
        'grand_total',
        'order_status',
        'status',
        'order_date',
        'created_by',
        'updated_by',
        'delivery_type',
        'store_id',
        'delivery_details',
        'tracking_num',
        'transaction_id',
        'failure_message',
        'failure_status_message',
        'ref_no',
        'payment_mode',
        'card_name',
        'currency',
        'billing_notes',
        'trans_date'
    ];


       public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }


}
