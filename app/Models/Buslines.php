<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buslines extends Model
{
    protected $table = 'buslines';
    protected $fillable = [
        'name',
        'company_id',
        'city_start',
        'city_end',
        'departure_time',
        'arrival_time',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(BuslinesCompany::class, 'company_id', 'id');
    }

    public function cityStart()
    {
        return $this->belongsTo(City::class, 'city_start', 'id');
    }

    public function cityEnd()
    {
        return $this->belongsTo(City::class, 'city_end', 'id');
    }

    public function stations()
    {
        return $this->hasMany(BuslinesStation::class, 'busline_id');
    }

}
