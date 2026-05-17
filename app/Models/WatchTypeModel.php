<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchTypeModel extends Model
{
    protected $table = 'mst_watch_type';

    protected $primaryKey = 'wt_id';

    public $timestamps = true; // because created_at & updated_at exist

    protected $fillable = [
        'title',
        'desc',
        'status',
        'created_by',
        'updated_by',
    ];
}
