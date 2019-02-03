<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string identifier
 * @property string name
 * @property string email
 */
class Tenant extends Model
{
    protected $fillable = [
        'identifier', 'name', 'email'
    ];

    /**
     * A tenant has one hostname
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hostname() {
        return $this->hasOne(Hostname::class);
    }
}
