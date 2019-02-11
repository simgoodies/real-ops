<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplication;
use App\Services\ApplicationService;

class ApplicationController extends Controller
{

    public function index()
    {
        return view('core.applications.index');
    }
}
