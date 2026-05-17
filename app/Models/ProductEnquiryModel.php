<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEnquiryModel extends Model
{
    protected $table = 'tbl_product_enquiries';
    protected $primaryKey = 'enquiry_id';
    protected $fillable = ['date', 'name', 'email', 'mobile', 'pro_id', 'product_name', 'model_number', 'sku', 'country', 'state', 'city', 'message', 'price_range', 'year_range', 'from_panel', 'status', 'created_by', 'updated_by'];
}
