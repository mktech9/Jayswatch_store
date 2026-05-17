<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_smtp';

    protected $primaryKey = 'smtp_id';

    public $timestamps = false;

    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'status',
        'updated_by',
    ];
}
