<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{

    protected $table = 'mst_brand';


    protected $primaryKey = 'brand_id';


    public $timestamps = true;


    protected $fillable = [
        'brand_name',
        'brand_desc',
        'meta_title',
        'brand_img',
        'status',
        'created_by',
        'updated_by'
    ];
}
