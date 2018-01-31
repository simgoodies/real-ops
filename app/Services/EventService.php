<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\Request;

class EventService
{
    /**
     * @param Request $request
     * @return Event
     */
    public function processNewEvent(Request $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;

        $event->save();

        return $event;
    }
}