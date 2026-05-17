<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    protected $table = 'tbl_contacts';
    protected $primaryKey = 'contact_id';
    public $timestamps = true;

    protected $fillable = [
        'date',
        'name',
        'email',
        'mobile',
        'country',
        'city',
        'store',
        'message',
        'status'
    ];
}
