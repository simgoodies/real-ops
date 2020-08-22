<?php

namespace App\Models;

use Parental\HasParent;

class BookableTimeSlot extends Bookable
{
    use HasParent;

    const TYPE = 'time-slot';

    const DIRECTION_DEPARTURE = 'departure';
    const DIRECTION_ARRIVAL = 'arrival';
    const DURATION_HOUR = 60;
    const DURATION_HALFHOUR = 30;

    protected $table = 'bookables';

    protected $attributes = [
        'type' => self::TYPE,
    ];
}
