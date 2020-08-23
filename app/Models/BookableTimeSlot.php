<?php

namespace App\Models;

use Parental\HasParent;

class BookableTimeSlot extends Bookable
{
    use HasParent;

    const TYPE = 'time-slot';

    const DIRECTION_OUTBOUND = 'outbound';
    const DIRECTION_INBOUND = 'inbound';
    const DIRECTION_ANY = 'any';
    const DURATION_HOUR = 60;
    const DURATION_HALFHOUR = 30;

    protected $table = 'bookables';

    protected $attributes = [
        'type' => self::TYPE,
    ];

    public function getAvailableBookablesAttribute()
    {
        return BookableTimeSlot::where('event_id', $this->event_id)
            ->where('begin_date', $this->begin_date)
            ->where('begin_time', $this->begin_time)
            ->where('end_date', $this->end_date)
            ->where('end_time', $this->end_time)
            ->where('data->direction', $this->data['direction'] ?? null)
            ->where('data->assignation', $this->data['assignation'] ?? null)
            ->count();
    }

    public function getNonBookedBookablesAttribute()
    {
        return BookableTimeSlot::where('event_id', $this->event_id)
            ->where('begin_date', $this->begin_date)
            ->where('begin_time', $this->begin_time)
            ->where('end_date', $this->end_date)
            ->where('end_time', $this->end_time)
            ->where('data->direction', $this->data['direction'] ?? null)
            ->where('data->assignation', $this->data['assignation'] ?? null)
            ->whereNull('booked_by_id')
            ->whereNull('booked_at')
            ->count();
    }

    public function getNextAvailableBooking()
    {
        Return BookableTimeSlot::where('event_id', $this->event_id)
            ->where('begin_date', $this->begin_date)
            ->where('begin_time', $this->begin_time)
            ->where('end_date', $this->end_date)
            ->where('end_time', $this->end_time)
            ->where('data->direction', $this->data['direction'] ?? null)
            ->where('data->assignation', $this->data['assignation'] ?? null)
            ->whereNull('booked_by_id')
            ->whereNull('booked_at')
            ->first();
    }

    public static function getPreviouslyUsedAssignations(Event $event)
    {
        return BookableTimeSlot::whereNotNull('data->assignation')->distinct()->get('data->assignation as assignation')->pluck('assignation');
    }
}
