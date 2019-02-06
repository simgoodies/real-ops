@component('mail::message')
Hi, {{ $application->contact_first_name or '' }}<br>
<br>
Your request to apply {{ $application->fir_name or '' }} to VATGoodies - Real Ops has been received successfully.<br>
We will review the request and provide you with an update as soon as possible!<br>
<br>
Your interest in VATGoodies - Real Ops is highly appreciated.<br>
<br>
<br>
Greetings,<br>
VATGoodies - Real Ops
@endcomponent