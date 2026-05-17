<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMaster extends Model
{
    protected $table = 'mst_contact_master';
    protected $primaryKey = 'contact_master_id';
    public $timestamps = true;

    protected $fillable = [
        'is_business', 'contact_id', 'prefix', 'first_name', 'middle_name', 'last_name',
        'date_of_birth', 'business_name', 'mobile', 'alternate_contact_number',
        'landline', 'email','gst_number', 'id_proof_type', 'id_number', 'id_file_path',
        'assigned_to', 'tax_number', 'opening_balance', 'pay_term', 'pay_term_period',
        'credit_limit', 'address_line_1', 'address_line_2', 'city', 'state',
        'country', 'zip_code', 'status', 'created_by', 'updated_by'
    ];
}