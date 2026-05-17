<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    protected $table = 'mst_clients';
    protected $primaryKey = 'client_id';
    public $timestamps = true;

    protected $fillable = [
        'client_name',
        'review',
        'status',
        'created_by',
        'updated_by'
    ];
}