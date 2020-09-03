@component('mail::message')
# {{ $event->title }}

Your booking was confirmed successfully!

Booking details:

@if($bookable->data['direction'] == \App\Models\BookableTimeSlot::DIRECTION_ANY)
Time slot in any direction
@endif
@if($bookable->data['direction'] == \App\Models\BookableTimeSlot::DIRECTION_INBOUND)
Time slot in the inbound direction
@endif
@if($bookable->data['direction'] == \App\Models\BookableTimeSlot::DIRECTION_OUTBOUND)
Time slot in the outbound direction
@endif
@isset($bookable->data['assignation'])
for {{ $bookable->data['assignation'] }}  
@endisset
Time slot date: {{ $bookable->begin_date->format('d M Y') }}  
Time slot time range: {{ $bookable->begin_time->format('H:i') }}Z to {{ $bookable->end_time->format('H:i') }}Z
@if($bookable->end_date->gt($bookable->begin_date))
(overnight)
@endif

Thanks,  
{{ config('app.name') }}
@endcomponent
