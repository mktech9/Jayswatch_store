<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxModel extends Model
{
    // Table name
    protected $table = 'tbl_tax';
    protected $primaryKey = 't_id';
    public $timestamps = false;
    protected $fillable = [
        'tax',
        'tax_rate',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
