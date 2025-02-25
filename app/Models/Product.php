<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'video_url',
        'category_id',
        'rate',
        'num_rate',
        'rate_text',
        'status',
        'favorite',
        'address',
        'zip_code',
        'phone',
        'fax',
        'email',
        'website',
        'description',
        'color',
        'icon',
        'tags',
        // 'country_id',
        'city_id',
        // 'state_id',
        'author_id',
        'galleries',
        'features',
        'open_hours',
        'socials',
        'gps',
        'link',
    ];

    protected $casts = [
        'image' => 'array',
        'tags' => 'array',
        'galleries' => 'array',
        'features' => 'array',
        'open_hours' => 'array',
        'socials' => 'array',
        'gps' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

/*     public function country()
    {
        return $this->belongsTo(Country::class);
    } */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

/*     public function state()
    {
        return $this->belongsTo(State::class);
    } */

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}