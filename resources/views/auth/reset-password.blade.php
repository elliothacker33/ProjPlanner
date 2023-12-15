@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush
<?php
        // Get the 'email' query parameter from the URL
        $email = $_GET['email'] ?? null;
?>

@section('content')
    <div class = "container ">
        <div class = "row p-4">
         
            <div class ="col-12" style = "margin-top: 5%;">
                <h1>Forgot your password</h1>
            </div>
            <div class = "col-12" style = "margin-top: 3%;">
                <h2>Please enter your new password</h2>
            </div>
            <div class ="col-12" style = "margin-top: 5%;">
            <form method="POST" class ="row" action="{{ route('password.update')}}">
                @csrf()
                <div class="form-group col-12 w-100">
    <label for="email">Email address</label>
    <input type="text" id="email" required value="{{ $email }}" class="p-3 inputemail" name="email" placeholder="myemail@company.com" value="{{ old('email') }}">
</div>

<div class="form-group col-12 w-100">
    <label for="password">Enter your new password</label>
    <input type="password" id="password" required class="p-3 inputemail" name="password">
</div>

<input type="text" id="token" hidden required value="{{ $token }}" name="token">

<div class="form-group col-12 w-100">
    <label for="password-confirmation">Confirm your new password</label>
    <input type="password" id="password_confirmation" required class="p-3 inputemail" name="password_confirmation">
</div>

            
                <div class = "col-12"  style = "margin-top: 3%;" >
                    <button class = "w-100"><p>Request reset link</p></button>
                </div>
                </form>
            </div>

         
        </div>


    </div>

@endsection