<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class BookableController extends Controller
{
    public function store(Request $request, Event $slug)
    {
        $type = $request->input('type');
    }

    public function index(Request $request, Event $slug)
    {
        return view('bookables.index', ['event' => $slug]);
    }
}
