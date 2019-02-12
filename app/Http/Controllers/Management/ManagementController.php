<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('management.index');
    }
}
