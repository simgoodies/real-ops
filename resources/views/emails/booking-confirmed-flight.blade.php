@component('mail::message')
# {{ $event->title }}

Your booking was confirmed successfully!

Booking details:

Callsign: {{ $bookable->data['callsign'] }}  
Departing from: {{ $bookable->data['origin_airport_icao'] }} on {{ $bookable->begin_date->format('d M Y') }} at {{ $bookable->begin_time->format('H:i') }}Z  
Arriving at: {{ $bookable->data['destination_airport_icao'] }} on {{ $bookable->end_date->format('d M Y') }} at {{ $bookable->end_time->format('H:i') }}Z

Thanks,  
{{ config('app.name') }}
@endcomponent
