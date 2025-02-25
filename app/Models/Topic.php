<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'featured_media_url',
        'date',
        'link',
        'categories',
        'tags'
    ];
}
