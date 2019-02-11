<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function landing()
    {
        return redirect()->route('tenants.office.index');
    }
}