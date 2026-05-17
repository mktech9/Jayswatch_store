<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstCountryModel extends Model
{
    protected $table = 'mst_country';

    protected $primaryKey = 'id';

    protected $fillable = [
        'sortname',
        'name',
        'phonecode'
    ];

    public $timestamps = false;

    public function states()
    {
        return $this->hasMany(MstStateModel::class, 'country_id', 'id');
    }
}
