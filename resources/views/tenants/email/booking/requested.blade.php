@component('vendor.mail.markdown.message')
# {{ $tenantName }} presents
## {{ $flight->event->title }}

Thanks for your booking request of flight {{ $flight->callsign }}.

Please confirm your booking by pressing the button below

@component('mail::button', ['url' => $url, 'color' => 'green'])
    Confirm booking for {{ $flight->callsign }}
@endcomponent

We will send you a summary of your booking upon confirmation!

Thanks,  
{{ $tenantName }}
@endcomponent
