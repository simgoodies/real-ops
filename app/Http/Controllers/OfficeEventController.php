<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeEvent;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfficeEventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return view('office-events.index', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        return view('office-events.create');
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
            'banner_url' => $request->banner_url,
        ]);

        $event->save();

        return redirect()->route('office-events.show', ['event' => $event])
            ->with('success', 'The event was created successfully');
    }

    public function show(Event $event)
    {
        return view('office-events.show')->with(['event' => $event]);
    }

    public function destroy(Request $request, Event $event)
    {
        $confirmText = $request->input('confirmText');
        $confirmText = Str::lower($confirmText);

        if (!Str::contains($confirmText, 'this is intentional')) {
            session()->flash('event-delete-failure', 'Confirmation was filled incorrectly!');
            return redirect()->route('office-events.show', ['event' => $event]);
        }

        $event->delete();
        session()->flash('success', 'Event was deleted successfully!');

        return redirect()->route('office-events.index');
    }
}
