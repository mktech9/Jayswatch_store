<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiBlogModel extends Model
{
    protected $table = 'multi_blog';

    protected $primaryKey = 'mb_id';

    public $timestamps = false;

    protected $fillable = [
        'blog_id',
        'heading',
        'main_img',
        'caption',
        'content',
        'bottom_img',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    // Relationship with Blog
    public function blog()
    {
        return $this->belongsTo(BlogModel::class, 'blog_id', 'blog_id');
    }
}
