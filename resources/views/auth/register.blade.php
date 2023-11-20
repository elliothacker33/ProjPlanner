@extends('layouts.app')

@push('styles')

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <section class="authentication">

        <section class="formContainer">
        <header>
            <h2><span class="shine">Empower</span> Your Day, <span class="shine">Unleash</span> the work </h2>
            <h2>Sign-up:</h2>
        </header>
        <form method="POST" action="{{ route('create_account') }}">
            @csrf

                <input id="name" type="text" placeholder="Insert your name" name="name" value="{{ old('name') }}" required autofocus>
                @if($errors->has('name'))
                    <span class="error">
                        {{ $errors->first('name') }}
                    </span>
                @endif


                <input id="email" type="email" placeholder="Insert your email" name="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                @endif

                <input id="password" type="password" name="password" placeholder="Password" required>
                @if($errors->has('password'))
                    <span class="error">
                        {{ $errors->first('password') }}
                    </span>
                @endif

                <input id="password-confirm" type="password" placeholder="Confirm your password" name="password_confirmation" required>
                @if($errors->has('password_confirmation'))
                    <span class="error">
                        {{ $errors->first('password_confirmation') }}
                    </span>
                @endif

                <button type="submit">
                    Register
                </button>


        </form>
        </section>
    <section class="container">
        <h2>New Here?</h2>
        <p>Sign up and discover the best project manager tool.</p>
        <a class="button" href="{{ route('register') }}">Register</a>
    </section>
    </section>
@endsection
