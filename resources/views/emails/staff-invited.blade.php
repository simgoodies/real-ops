@component('mail::message')
# {{ $tenant->name }} invited you to join the team!

Click the button below to join:
@component('mail::button', ['url' => '#', 'color' => 'success'])
    Join {{ $tenant->name }}
@endcomponent

If you can't see the button, copy and paste this url in your browser:
{{ '#' }}

Thanks,  
{{ config('app.name') }}
@endcomponent
