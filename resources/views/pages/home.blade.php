@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/home.js') }}" defer></script>
@endpush

@section('content')
    <section class="home-content">

        <h1>Welcome to ProjPlanner</h1>
        <p>Your Ultimate Project Planning Platform</p>

        <section class="home-center">
            <h2>Empower Your Ideas, Realize Your Vision!</h2>
            <p>At ProjPlanner, we understand that every project is unique, and planning is the key to success. Whether you're a seasoned project manager or embarking on your first venture, we've got you covered.</p>
            <p>Get started today by signing up for free and take your first step towards turning your ideas into reality.</p>
            <button class="signin-btn">Sign In</button> | <button class="register-btn">Register</button>
        </section>
    </section>
@endsection