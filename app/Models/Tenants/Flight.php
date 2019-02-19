<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{

    public function getRouteKeyName()
    {
        return 'callsign';
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
}
