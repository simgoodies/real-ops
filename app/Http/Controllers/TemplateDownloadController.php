<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class TemplateDownloadController extends Controller
{
    public function flightTemplate()
    {
        return Response::download(resource_path('flights-template.csv'));
    }
}
