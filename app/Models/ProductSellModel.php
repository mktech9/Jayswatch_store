<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSellModel extends Model
{

    protected $table = 'tbl_selling';


    protected $primaryKey = 'selling_id';


    public $timestamps = true;


    protected $fillable = [
        'brand_id',
        'model_no',
        'price',
        'image',
        'name',
        'email_id',
        'contact_no',
        'country',
        'state',
        'city',
        'created_at',
        'created_by',
        'status'
    ];

    public function brandInfo()
    {
        return $this->belongsTo(BrandModel::class, 'brand_id', 'brand_id');
    }
}
