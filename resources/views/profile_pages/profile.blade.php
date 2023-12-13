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

        <h2>{{ $user->name }}</h2>
            <div id="wrapper">
                <div>
                    <p>Email:</p>
                </div>
                <div>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
        </section>

    @if(auth()->check() && auth()->user()->id == $user->id)
        <section class="actions">
            <div>
                <form class="hidden-form" id="remove-user-form" action="{{ route('delete_user', ['user' => Auth::id()]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <button type="submit" form="remove-user-form">Remove Account</button>
            </div>
            <div>
                <a href="{{ route('edit_profile', ['user' => $user->id]) }}">Edit profile</a>
            </div>
        </section>
    @endif


@endsection
