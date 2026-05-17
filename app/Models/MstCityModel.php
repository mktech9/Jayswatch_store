<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstCityModel extends Model
{
    protected $table = 'mst_city';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'state_id'
    ];

    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(MstStateModel::class, 'state_id', 'id');
    }
}
