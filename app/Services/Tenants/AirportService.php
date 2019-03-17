<?php

namespace App\Services\Tenants;

use App\Models\Airport;

class AirportService
{
    /**
     * Get the airport based on the provided icao.
     *
     * @param string $icao
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByIcao(string $icao)
    {
        return Airport::where('icao', $icao)->first();
    }
}
