<!-- your-page.blade.php -->

@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush



    @section('navbar')
        <li><a><span>Option 1</span></a></li>
        <li><a><span>Option 2</span></a></li>
        <li><a><span>Option 3</span></a></li>
        <li><a><span>Option 4</span></a></li>
    @endsection


@section('content')
<section class="container">
                <section class="contactInfo">
                    <section>
                        <h1>|&nbsp Contacts</h1>
                        <ul class="info">
                            <li >
                                &nbsp &nbsp &nbsp
                                <img class="icon" src="{{ asset('img/email_icon.png') }}" alt="default user icon">
                                <span>|&nbsp admin@gmail.com </span>
                            </li>
                            <li >
                                &nbsp &nbsp &nbsp
                                <img class="icon" src="{{ asset('img/phone_icon.png') }}" alt="default user icon">
                                <span>|&nbsp +351 224 119 040 </span>
                            </li>
                            <li >
                                &nbsp &nbsp &nbsp
                                <img class="icon" src="{{ asset('img/phone_icon.png') }}" alt="default user icon">
                                <span>|&nbsp +351 934 119 040 </span>
                            </li>
                        </ul>
                        <h1>|&nbsp Address</h1>
                        <ul class="info">
                            <li >
                                &nbsp &nbsp &nbsp |&nbsp 2791 Star Route Porto Portugal
                            </li>
                        </ul>
                    </section>
                    <ul class="sci">
                        <li><a href=""><i></i></a></li>
                        <li><a href=""><i></i></a></li>
                    </ul>
                </section>
</section>


@endsection
