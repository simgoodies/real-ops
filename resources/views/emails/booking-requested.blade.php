@component('mail::message')
Confirmation URL: {{ $confirmationUrl }}

Thanks,
{{ config('app.name') }}
@endcomponent
