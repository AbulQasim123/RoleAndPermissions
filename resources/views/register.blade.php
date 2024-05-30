@extends('layouts.auth-layout')

@section('content')
    <form action="{{ route('post.register') }}" method="post">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1>Register</h1>
        <fieldset>
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ old('name') }}">
            {{-- @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror --}}

            <label for="mail">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}">
            {{-- @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror --}}
            <label for="password">Password:</label>
            <input type="password" name="password">
            {{-- @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror --}}
        </fieldset>
        <button type="submit">Register</button>
    </form>
@endsection
