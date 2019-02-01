<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    public function index()
    {
        return view('office.index');
    }
}
