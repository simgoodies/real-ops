<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\BookableFlight;

class BookableController extends Controller
{
    public function store(Request $request, Event $slug)
    {
        $type = $request->input('type');


    }
}
