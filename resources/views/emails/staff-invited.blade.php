@component('mail::message')
# You're invited by {{ $tenant->name }}!

{{ $tenant->name }} wants you to join their team on the Real Ops by Simgoodies platform.

Click below to accept the invitation:
@component('mail::button', ['url' => 'google.com', 'color' => 'success'])
    Accept invitation
@endcomponent

See [{{config('app.url') }}]({{config('app.url') }}) to find out more about Real Ops by Simgoodies.

If you can't see the button, copy and paste this url in your browser:

Thanks,

{{ config('app.name') }}
@endcomponent
