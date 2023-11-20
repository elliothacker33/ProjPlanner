@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @endpush

    <section class="authentication">

        <section class="formContainer">
            <section class="header">
                <p><span class="shine">Empower</span> Your Day, <span class="shine">Unleash</span> the work </p>
                <h2>Login to Your Account</h2>
            </section>


        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="error">
          {{ $errors->first('email') }}
        </span>
            @endif

            <input id="password" type="password" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="error">
            {{ $errors->first('password') }}
        </span>
            @endif

            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>

            <button type="submit">
                Login
            </button>

            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif
        </form>
        </section>
        <section class="container">

            <a class="button button-outline" href="{{ route('register') }}">Register</a>
        </section>
    </section>

@endsection