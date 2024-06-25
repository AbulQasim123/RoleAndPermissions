@component('mail::message')
    # Your Account Deleted

    Your account has been deleted by Super Admin.

    **Name:** {{ $details['username'] }}


    **Thank you**
@endcomponent
