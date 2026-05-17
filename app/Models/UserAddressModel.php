<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddressModel extends Model
{


    // ✅ Table name
    protected $table = 'user_address'; // change if your table name is different

    // ✅ Primary key
    protected $primaryKey = 'ua_id';

    // ✅ Timestamps (disable if not using Laravel's default `created_at` & `updated_at`)
    public $timestamps = false;

    // ✅ Fillable fields (mass assignable)
    protected $fillable = [
        'user_id',
        'address_type',
        'u_pincode',
        'u_address1',
        'u_address2',
        'u_city',
        'u_state',
        'u_country',
        'is_primary',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];
}
