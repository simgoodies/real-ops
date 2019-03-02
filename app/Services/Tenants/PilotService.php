<?php

namespace App\Services\Tenants;

use App\Models\Tenants\Pilot;

class PilotService
{
    /**
     * @return Pilot[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Pilot::all();
    }

    /**
     * @param string $vatsimId
     * @return mixed
     */
    public function getByVatsimId(string $vatsimId)
    {
        return Pilot::where('vatsim_id', $vatsimId)->first();
    }

    /**
     * Too determine whether a pilot with given vatsim id exists.
     *
     * @param string $vatsimId
     * @return mixed
     */
    public function existsByVatsimId(string $vatsimId)
    {
        return Pilot::where('vatsim_id', $vatsimId)->exists();
    }

    public function firstOrCreatePilot(array $attributes)
    {
        return Pilot::firstOrCreate($attributes);
    }
}
