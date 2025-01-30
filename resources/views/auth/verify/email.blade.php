@component('mail::message')
# Verify Your Email Address

Hi {{ $user->name }},  

Thank you for signing up! Please verify your email address by clicking the button below.

@component('mail::button', ['url' => $verificationUrl])
Verify Email Address
@endcomponent

If the button above doesn't work, copy and paste this link into your web browser:  
[{{ $verificationUrl }}]({{ $verificationUrl }})

If you did not create an account, no further action is required.

Thanks,  
**{{ config('app.name') }}**
@endcomponent
