<?php

namespace App\Models\Tenants;

use Hyn\Tenancy\Abstracts\TenantModel;

class Pilot extends TenantModel
{

    protected $fillable = ['vatsim_id', 'email'];
    /**
     * The bookings that the pilot has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Flight::class);
    }
}
