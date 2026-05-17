<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderModel extends Model
{
    protected $table = 'mst_sliders';
    protected $primaryKey = 'slider_id';
    public $timestamps = true;

    protected $fillable = [
        'desktop_image',
        'mobile_image',
        'status',
        'created_by',
        'updated_by'
    ];
}