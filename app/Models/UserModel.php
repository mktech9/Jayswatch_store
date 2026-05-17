<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{


    // Table name
    protected $table = 'tbl_users';

    // Primary key
    protected $primaryKey = 'user_id';


    // Mass assignable columns
    protected $fillable = [
        'user_name',
        'full_name',
        'first_name',
        'last_name',
        'profile_pic',
        'citizen_type',
        'pan_no',
        'pan_json',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'email',
        'password',
        'phone',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    // Timestamps (you can disable if handled manually)
    public $timestamps = true;
}
