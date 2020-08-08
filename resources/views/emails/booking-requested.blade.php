@component('mail::message')
# {{ $event->title }}

Click the button below to confirm your booking request:  
@component('mail::button', ['url' => $confirmationUrl, 'color' => 'success'])
    Confirm booking
@endcomponent

If you can't see the button, copy and paste this url in your browser:  
{{ $confirmationUrl }}

**Important:** The booking is not reserved / locked. If this booking request is not promptly confirmed, it may be taken.

Thanks,  
{{ config('app.name') }}
@endcomponent
