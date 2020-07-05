<?php

namespace App\Models;

use Parental\HasParent;

class BookableFlight extends Bookable
{
    use HasParent;

    const TYPE = 'flight';

    protected $table = 'bookables';

    protected $attributes = [
        'type' => 'flight'
    ];
}
