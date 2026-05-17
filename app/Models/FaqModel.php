<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqModel extends Model
{
    protected $table = 'faq';

    protected $primaryKey = 'faq_id';

    public $timestamps = false;

    protected $fillable = [
        'question',
        'answer',
        'type',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
}
