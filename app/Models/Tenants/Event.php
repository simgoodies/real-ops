<?php

namespace App\Models\Tenants;

use Hyn\Tenancy\Abstracts\TenantModel;
use Cviebrock\EloquentSluggable\Sluggable;

class Event extends TenantModel
{
    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
