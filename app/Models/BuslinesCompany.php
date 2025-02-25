<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuslinesCompany extends Model
{
    protected $table = 'buslines_companies';
    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'address',
        'city',
        'logo',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];
}
