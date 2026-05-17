<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinesslocationModel extends Model
{
    // Table name
    protected $table = 'tbl_bussiness_location';
    protected $primaryKey = 'bl_id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'location_id',
        'city',
        'zip_code',
        'state',
        'country',
        'address',
        'gst_number',
        'mobile',
        'alternate_contact',
        'email',
        'product',
        'payment_options',
        'monthly_turnover',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
