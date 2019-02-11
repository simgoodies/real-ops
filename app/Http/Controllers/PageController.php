<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function landing()
    {
        return view('core.pages.landing');
    }

    public function contact()
    {
        return view('core.pages.contact');
    }

    public function application()
    {
        return view('core.pages.application');
    }
}
