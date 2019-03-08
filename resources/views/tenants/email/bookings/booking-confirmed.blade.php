@component('vendor.mail.markdown.message')
# {{ $tenantName }} presents
## {{ $event->title }}
<hr>
**Event Details**

Event date: {{ date('Y-m-d', strtotime($event->start_date)) }} at {{ date('Hi', strtotime($event->start_time)) }}Z until {{ date('Hi', strtotime($event->end_time)) }}Z

{{ $event->description }}
<hr>
**Summary of booking for {{ $flight->callsign }}**

Departing from: {{ $flight->origin_airport_icao }} at {{ date('Hi', strtotime($flight->departure_time)) }}Z  
Arriving at: {{ $flight->destination_airport_icao }}  
@if ($flight->aircraft_type_icao)
Aircraft: {{ $flight->aircraft_type_icao }}
@endif

@if ($flight->route)
Preferred Route:  
{{ $flight->route }}
@endif

We are looking forward to see you during {{ $event->title }}

Thanks,  
{{ $tenantName }}
@endcomponent
