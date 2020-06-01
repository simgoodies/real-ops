<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeEvent;
use App\Models\Event;

class OfficeEventController extends Controller
{
    public function create()
    {
        return view('office-event.create');
    }

    public function store(StoreOfficeEvent $request)
    {
        $event = new Event([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
        ]);

        $event->save();

        return redirect()->route('office-event.show', ['slug' => $event])
            ->with('success', 'The event was created successfully');
    }

    public function show(Event $slug)
    {
        return view('office-event.show')->with(['event' => $slug]);
    }
}
