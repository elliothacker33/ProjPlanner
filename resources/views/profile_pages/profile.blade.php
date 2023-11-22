@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
    <header>
        <h1>Profile</h1>
    </header>
    
    <section class="info">
        <figure>
            <img  src="{{ asset('img/default-profile-photo.jpg') }}" alt="Default Image">
        </figure>
        <h2>{{ $profileName }}</h2>
        <div id="wrapper">
            <div>
                <p>Email:</p>
            </div>
            <div>
                <p>{{ $profileEmail }}</p>
            </div>
        </div>
    </section>

    @if(auth()->check() && auth()->user()->id === $user->id)
        <section class="actions">
            <button><p>Remove Account</p></button>
            <button><p>Edit profile</p></button>
        </section>
    @endif
@endsection
