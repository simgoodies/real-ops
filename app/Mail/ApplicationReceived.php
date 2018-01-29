<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Application $application */
    public $application;

    /**
     * Create a new message instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('VATGoodies - Real Ops application successful!')
            ->replyTo(env('NO_REPLY_EMAIL'))
            ->with([
                'application' => $this->application
            ])
            ->markdown('emails.applications.newapplication');
    }
}
