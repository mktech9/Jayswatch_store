<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'tbl_notification';

    protected $primaryKey = 'n_id';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = null; // because table has no updated_at

    protected $fillable = [
        'type',
        'description',
        'read_status',
        'submit_by',
        'created_by',
        'status',
    ];

    protected $casts = [
        'read_status' => 'integer',
        'status' => 'integer',
    ];
}
