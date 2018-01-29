<?php

namespace App\Listeners;

use App\Events\NewApplication;
use App\Mail\ApplicationReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNewApplicationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewApplication $event
     * @return void
     */
    public function handle(NewApplication $event)
    {
        Mail::to($event->application->contact_email)
            ->bcc(env('SUPER_ADMIN_EMAIL'))
            ->send(new ApplicationReceived($event->application));
    }
}
