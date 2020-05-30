<?php

namespace App\Models;

use Parental\HasParent;

class BookableFlight extends Bookable
{
    use HasParent;

    protected $table = 'bookables';

    protected $attributes = [
        'type' => 'flight'
    ];
}
