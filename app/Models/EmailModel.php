<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailModel extends Model
{
    protected $table = 'tbl_emails';
    protected $primaryKey = 'email_id';

    protected $fillable = [
        'email',
        'status',
        'created_by',
        'updated_by'
    ];
}
