<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'button',
        'image',
        'link',
        'link_type',
        'city',
        'category',
        'fetured',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'allDay' => 'boolean',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
