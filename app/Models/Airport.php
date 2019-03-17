<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'icao',
        'iata',
        'name',
        'elevation_feet',
        'continent',
        'iso_country',
        'iso_region',
        'municipality',
        'coordinates',
    ];
}
