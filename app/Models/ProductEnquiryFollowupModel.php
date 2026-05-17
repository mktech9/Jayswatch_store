<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEnquiryFollowupModel extends Model
{
    protected $table = 'tbl_product_enquiry_followups';
    protected $primaryKey = 'followup_id';
    protected $fillable = ['enquiry_id', 'note', 'curr_status', 'status', 'created_by', 'updated_by'];
}
