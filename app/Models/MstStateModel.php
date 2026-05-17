<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstStateModel extends Model
{
    protected $table = 'mst_state';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'country_id'
    ];

    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(MstCountryModel::class, 'country_id', 'id');
    }

    public function cities()
    {
        return $this->hasMany(MstCityModel::class, 'state_id', 'id');
    }
}
