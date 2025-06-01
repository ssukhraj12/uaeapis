<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $primaryKey = "blog_id";
    protected $fillable = [
        'blog_title',
        'blog_slug',
        'blog_description',
        'blog_image',
        'tags',
        'blog_status',
        'meta_title',
        'meta_desc',
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
