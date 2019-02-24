<?php

namespace App\Models\Tenants;

use Hyn\Tenancy\Abstracts\TenantModel;

class Flight extends TenantModel
{

    public function getRouteKeyName()
    {
        return 'callsign';
    }

    /**
     * Sets the callsign to uppercase
     *
     * @param $value
     */
    public function setCallsignAttribute($value)
    {
        $this->attributes['callsign'] = strtoupper($value);
    }

    /**
     * Sets the origin airport icao to uppercase
     *
     * @param $value
     */
    public function setOriginAirportIcaoAttribute($value)
    {
        $this->attributes['origin_airport_icao'] = strtoupper($value);
    }

    /**
     * Sets the destination airport icao to uppercase
     *
     * @param $value
     */
    public function setDestinationAirportIcaoAttribute($value)
    {
        $this->attributes['destination_airport_icao'] = strtoupper($value);
    }

    /**
     * Sets the route to uppercase
     *
     * @param $value
     */
    public function setRouteAttribute($value)
    {
        $this->attributes['route'] = strtoupper($value);
    }

    /**
     * The pilot that is associated with the flight.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pilot()
    {
        return $this->belongsTo('App\Models\Pilot');
    }

    /**
     * This method will let you know if a flight has been booked.
     *
     * @return bool
     */
    public function isBooked()
    {
        return $this->pilot()->get()->isNotEmpty();
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
