<?php

namespace App\Models;

use Hyn\Tenancy\Abstracts\SystemModel;

class Airport extends SystemModel
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
