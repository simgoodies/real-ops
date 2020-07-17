<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Event $slug)
    {
        return view('events.show', ['event' => $slug]);
    }
}
