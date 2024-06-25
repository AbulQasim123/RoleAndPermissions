{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create User Mail</title>
</head>

<body>
    <h2>Your Account created, and below are the your details.</h2>
    <p><strong>Name:- </strong>{{ $details['username'] }}</p>
    <p><strong>Email:- </strong>{{ $details['email'] }}</p>
    <p><strong>Password:- </strong>{{ $details['password'] }}</p>

    <p>You can login your account now</p>
    <p><b>Thank you</b></p>
</body>

</html> --}}


@component('mail::message')
    # Your Account Created

    Your account has been created, and below are your details.

    **Name:** {{ $details['username'] }}
    **Email:** {{ $details['email'] }}
    **Password:** {{ $details['password'] }}

    You can now log in to your account.

    **Thank you**
@endcomponent
