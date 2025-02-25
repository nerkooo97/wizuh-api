<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuslinesStation extends Model
{
    protected $table = 'buslines_stations';
    protected $fillable = [
        'name',
        'city',
        'address',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function busline()
    {
        return $this->belongsTo(Buslines::class, 'busline_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

}
