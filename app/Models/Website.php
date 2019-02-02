<?php

namespace App\Models;

use Hyn\Tenancy\Models\Website as BaseWebsite;

class Website extends BaseWebsite
{
    protected $fillable = [
        'uuid'
    ];
}
