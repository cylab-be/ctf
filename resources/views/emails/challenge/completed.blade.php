@component('mail::message')
Dear {{ $registration->user->name }},

Congratulations for participating in the Capture-the-Flag challenge **{{ $registration->challenge->name }}**!

Your score: **{{ $registration->score }} points**

Your ranking: **{{ ordinal($registration->position()) }} out of {{ $registration->challenge->participants() }} participants**

You can download your certificate of participation on your profile page.

@component('mail::button', ['url' => action('AccountController@show')])
Get your certificate
@endcomponent

Regards,<br>

{{ config('app.name') }}
@endcomponent
