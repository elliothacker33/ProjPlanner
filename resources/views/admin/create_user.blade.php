@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <link href="{{ asset('js/admin/create_user.js') }}" defer>
@endpush

@section('content')
<section class="authentication register">

    <section class="formContainer">
    <header>
        <h2><span class="shine">Empower</span> Your Day, <span class="shine">Unleash</span> the work </h2>
        <h2>Create User</h2>
    </header>
    <form method="POST" action="{{ route('create_account') }}">
        @csrf

            <input id="name" type="text" placeholder="Insert user's name" name="name" value="{{ old('name') }}" required autofocus>
            @if($errors->has('name'))
                <span class="error">
                    {{ $errors->first('name') }}
                </span>
            @endif


            <input id="email" type="email" placeholder="Insert user's email" name="email" value="{{ old('email') }}" required>
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

            <input id="password-confirm" type="password" placeholder="Confirm user's password" name="password_confirmation" required>
            @if($errors->has('password_confirmation'))
                <span class="error">
                    {{ $errors->first('password_confirmation') }}
                </span>
            @endif

            <label for="is_admin"> <input id="is_admin" type="checkbox" name="is_admin" value="1"> Admin</label>

            <button type="submit">
                Create
            </button>


    </form>
    </section>

</section>

@endsection