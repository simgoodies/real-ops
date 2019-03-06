<?php

namespace App\Http\Controllers\Tenants\Office;

use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    public function index()
    {
        return view('tenants.office.index');
    }
}
