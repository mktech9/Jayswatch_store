<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContentModel extends Model
{
    protected $table = 'tbl_about_content';

    protected $primaryKey = 'ac_id';

    public $timestamps = false; // since you're using custom created_at & updated_at

    protected $fillable = [
        'about_heading',
        'about_content',

        'section1_image',
        'section1_heading',
        'section1_content',

        'section2_image',
        'section2_heading',
        'section2_content',

        'section3_image',
        'section3_heading',
        'section3_content',

        'meta_title',
        'meta_description',

        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
