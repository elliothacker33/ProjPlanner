@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush

@section('content')
    <header>
        <h1> Edit Profile</h1>
    </header>
    <figure>
        <img src="{{ asset('img/default-profile-photo.jpg') }}" alt="Default Image">
    </figure>
    <form method="POST" action="{{ route('update_profile', ['usrId' => $usrId])}}">
        @csrf()
        @method('PUT')
        <input type="text" name="name" placeholder="Choose your name" value="{{ old('name') }}">

        @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
        @endif

        <input type="text" name="email" placeholder="Update your email" value="{{ old('email') }}">

        @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
        @endif

        <input type="password" name="old_password" placeholder="Old password">

        @if ($errors->has('old_password'))
            <span class="error">
                {{ $errors->first('old_password') }}
            </span>
        @elseif(session('error'))
            <span class="error">
                {{ session('error') }}
            </span>
        @endif

        <input type="password" name="new_password" placeholder="Choose new password">

        @if ($errors->has('new_password'))
            <span class="error">
                {{ $errors->first('new_password') }}
            </span>
        @endif

        <button><p>Update Profile</p></button>
    </form>
@endsection
