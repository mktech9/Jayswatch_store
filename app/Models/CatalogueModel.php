<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogueModel extends Model
{
    protected $table = 'tbl_catalogue';

    protected $primaryKey = 'cg_id';

    public $timestamps = false; // since custom fields used

    protected $fillable = [
        'file',
        'date',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
