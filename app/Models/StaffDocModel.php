<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDocModel extends Model
{
    use HasFactory;

    protected $table = 'staff_doc';
    protected $primaryKey = 'sd_id';

    protected $fillable = [
        'staff_id',
        'title',
        'description',
        'files',
        'is_private',
        'status',
        'created_by',
        'updated_by'
    ];


    public function staff()
    {
        return $this->belongsTo(StaffModel::class, 'staff_id', 'staff_id');
    }
}
