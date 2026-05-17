<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAdminModel extends Model
{
     protected $table = 'super_admin';

    protected $primaryKey = 'sp_id';

    protected $fillable = [
        'sp_name',
        'sp_username',
        'sp_email',
        'sp_password',
        'status',
    ];
}
