<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TCSModel extends Model
{
    // Table name
    protected $table = 'tbl_tcs';
    protected $primaryKey = 'tcs_id';
    public $timestamps = false;

    protected $fillable = [
        'percentage',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
