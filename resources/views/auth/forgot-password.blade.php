@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush

@section('content')
    <div class = "container ">
        <div class = "row p-4">
         
            <div class ="col-12" style = "margin-top: 5%;">
                <h1>Forgot your password</h1>
            </div>
            <div class = "col-12" style = "margin-top: 3%;">
                <h2>Please enter the email address you'd like your password reset information sent to</h2>
            </div>
            <div class ="col-12" style = "margin-top: 5%;">
            <form method="POST" class ="row" action="{{ route('password.email')}}">
                @csrf()
                <div class = "form-group col-12 w-100">
                    <label for="name">Enter email address</label>
                    <input type="text" id = "email" class="p-3 inputemail"name="email" placeholder="myemail@company.com" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                @endif
                </div>
                <div class = "col-12"  style = "margin-top: 3%;" >
                    <button class = "w-100"><p>Request reset link</p></button>
                </div>
                </form>
            </div>

            <div class="col-12 text-center goback" >
                <a href="{{ url()->previous() }}">Go back</a>
            </div>
        </div>


    </div>

@endsection