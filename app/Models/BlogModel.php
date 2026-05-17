<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    protected $table = 'mst_blog';

    protected $primaryKey = 'blog_id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'banner',
        'description',
        'is_multiple',
        'content_title',
        'view_count',
        'editors_pick',
        'features_blog',
        'brand',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
