<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlassMaterialModel extends Model
{
    protected $table = 'mst_glass_material';

    protected $primaryKey = 'gm_id';

    public $timestamps = true; // because created_at & updated_at exist

    protected $fillable = [
        'title',
        'desc',
        'status',
        'created_by',
        'updated_by',
    ];
}
