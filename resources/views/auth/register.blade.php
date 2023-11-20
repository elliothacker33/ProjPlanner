@extends('layouts.default')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
    <main>
        <header>
            <p><span class="shine">Empower</span> Your Day, <span class="shine">Unleash</span> the work </p>
            <h1>Sign-up:</h1>
        </header>
        <form method="POST" action="{{ route('create_account') }}">
            @csrf
            <div>
                <input id="name" type="text" placeholder="Insert your name" name="name" value="{{ old('name') }}" required autofocus>
                @if($errors->has('name'))
                    <span class="error">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div>
                <input id="email" type="email" placeholder="Insert your email" name="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div>
                <input id="password" type="password" placeholder="Choose a password" name="password" required>
                @if($errors->has('password'))
                    <span class="error">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
            <div>
                <input id="password-confirm" type="password" placeholder="Confirm your password" name="password_confirmation" required>
                @if($errors->has('password_confirmation'))
                    <span class="error">
                        {{ $errors->first('password_confirmation') }}
                    </span>
                @endif
            </div>
            <div>
                <button type="submit">
                    Register
                </button>
            </div>
            <div>
                <a href="{{ route('login') }}">Already have an account? <span class="login-link">Login</span></a>
            </div>
        </form>
    </main>
    <div id="info">
        <header>
            <p>Project planner,<br>is the go-to project management tool...</p>
        </header>
        <section>

        </section>
        <footer>
            <p>&copy; 2023 Project Planner. All Rights Reserved.</p>
        </footer>
    </div>
@endsection
