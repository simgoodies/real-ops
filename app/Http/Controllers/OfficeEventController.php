<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class OfficeEventController extends Controller
{
    public function store(Request $request)
    {
        $event = new Event([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $event->save();

        return redirect()->route('office-event.show', ['slug' => $event])
            ->with('success', 'The event was created successfully');
    }
}
