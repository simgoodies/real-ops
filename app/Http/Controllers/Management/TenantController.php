<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('management.tenants.index');
    }
}
