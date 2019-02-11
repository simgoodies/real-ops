<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplication;
use App\Services\ApplicationService;

class ApplicationController extends Controller
{

    public function index() {
        return view('core.applications.index');
    }

    public function create()
    {
        return view('applications.create');
    }
    public function store(StoreApplication $request)
    {
        $applicationService = new ApplicationService();
        $applicationService->processNewApplication($request);

        return redirect()->route('applied.index');
    }
}
