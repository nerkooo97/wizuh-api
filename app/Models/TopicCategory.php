<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicCategory extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
