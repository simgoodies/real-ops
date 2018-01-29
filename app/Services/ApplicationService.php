<?php

namespace App\Services;

use App\Events\NewApplication;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationService
{
    public function processNewApplication(Request $request)
    {
        $application = new Application();
        $application->fir_name = $request->fir_name;
        $application->contact_first_name = $request->contact_first_name;
        $application->contact_last_name = $request->contact_last_name;
        $application->contact_email = $request->contact_email;
        $application->vatsim_id = $request->vatsim_id;
        $application->icao = $request->icao;
        $application->motivation = $request->motivation;

        $application->save();

        event(new NewApplication($application));
    }
}