<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = 'tbl_role';

    protected $primaryKey = 'role_id';

    public $timestamps = true;

    protected $fillable = [
        'role_name',
        'role_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'role_status' => 'boolean',
    ];
}
