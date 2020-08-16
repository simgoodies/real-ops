<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class TemplateDownloadController extends Controller
{
    public function flightTemplate()
    {
        return Storage::disk('central-local')->download('flights-template.csv');
    }
}
