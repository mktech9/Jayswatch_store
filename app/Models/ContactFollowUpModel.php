<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFollowUpModel extends Model
{
    protected $table = 'tbl_contact_followups';
    protected $primaryKey = 'followup_id';
    public $timestamps = true;

    protected $fillable = [
        'contact_id',
        'note',
        'curr_status',
        'status',
        'created_by',
        'updated_by'
    ];
}
