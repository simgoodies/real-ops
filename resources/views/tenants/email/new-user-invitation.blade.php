@component('vendor.mail.markdown.message')
# {{ $tenantName }} Real Ops
## Staff member invitation
<hr>

You have been invited to be a member of {{ $tenantName }} Real Ops.

Use the button below to accept the invitation and setup a password:

@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Accept invitation...
@endcomponent

Thanks,  
{{ $tenantName }}
@endcomponent
