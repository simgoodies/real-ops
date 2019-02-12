<?php

namespace App\Models;

use Hyn\Tenancy\Abstracts\SystemModel;

/**
 * @property string identifier
 * @property string name
 * @property string email
 */
class Tenant extends SystemModel
{
    protected $fillable = [
        'identifier',
        'name',
        'email',
    ];

    /**
     * A tenant has one hostname.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hostname()
    {
        return $this->hasOne(Hostname::class);
    }
}
