<?php

namespace App\Models\Tenants;

use Cviebrock\EloquentSluggable\Sluggable;
use Hyn\Tenancy\Abstracts\TenantModel;

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
                'source' => 'title'
            ]
        ];
    }
}
