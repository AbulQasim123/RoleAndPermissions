@component('mail::message')
    # Your Account Created

    Your account has been created, and below are your details.

    **Name:** {{ $details['username'] }}
    **Email:** {{ $details['email'] }}
    **Password:** {{ $details['password'] }}

    You can now log in to your account.

    **Thank you**
@endcomponent
