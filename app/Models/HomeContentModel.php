<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContentModel extends Model
{
    protected $table = 'tbl_home_content';
    protected $primaryKey = 'hc_id';
    public $timestamps = true;

    protected $fillable = [
        'slider_heading',
        'slider_content',
        'second_banner_image',
        'second_top_signature_image',
        'second_banner_heading',
        'second_banner_content',
        'content_image',
        'icon_image',
        'mobile_content_image',
        'mobile_icon_image',
        'watch_list_heading',
        'list_top_paragraph',
        'list_bottom_paragraph',
        'meta_title',
        'meta_description',
        'status',
        'created_by',
        'updated_by'
    ];
}
