<?php

namespace App\Models;

use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string identifier
 * @property string name
 * @property string email
 */
class Tenant extends Model
{
    use UsesSystemConnection;

    protected $fillable = [
        'identifier',
        'name',
        'email'
    ];

    /**
     * A tenant has one hostname
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hostname()
    {
        return $this->hasOne(Hostname::class);
    }
}
