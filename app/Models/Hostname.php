<?php

namespace App\Models;

use Hyn\Tenancy\Models\Hostname as BaseHostname;

class Hostname extends BaseHostname
{
    /**
     * A hostname belongs to one tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo('App\Models\Tenant');
    }
}
