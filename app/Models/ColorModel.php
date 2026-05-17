<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorModel extends Model
{
    protected $table = 'mst_color';

    protected $primaryKey = 'color_id';

    public $timestamps = true; // because created_at & updated_at exist

    protected $fillable = [
        'title',
        'status',
        'created_by',
        'updated_by',
    ];
}
