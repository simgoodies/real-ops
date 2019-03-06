@component('vendor.mail.markdown.message')
# {{ $tenantName }} presents
## {{ $event->title }}

We have received your request to cancel your booking for flight {{ $flight->callsign }}.

Please confirm your cancellation request by pressing the button below

@component('mail::button', ['url' => $url, 'color' => 'red'])
    Confirm cancellation for {{ $flight->callsign }}
@endcomponent

Thanks,  
{{ $tenantName }}
@endcomponent
