@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
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
        <input type="text" name="name" placeholder="Choose your name">
        <input type="text" name="email" placeholder="Update your email">
        <input type="password" name="oldp" placeholder="Old password">
        <input type="password" name="newp" placeholder="Choose new password">
        <button><p>Update Profile</p></button>
    </form>
@endsection
