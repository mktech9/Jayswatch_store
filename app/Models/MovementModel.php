<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementModel extends Model
{
    protected $table = 'mst_movement';

    protected $primaryKey = 'm_id';

    public $timestamps = true; // because created_at & updated_at exist

    protected $fillable = [
        'title',
        'status',
        'created_by',
        'updated_by',
    ];
}
