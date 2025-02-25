<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'count',
        'image',
        'icon',
        'color',
        'type',
        'has_child',
        'category_image',
    ];

    protected $casts = [
        'image' => 'array', // Cast the image field to an array
        'has_child' => 'boolean', // Cast has_child to boolean
    ];
}