<!-- your-page.blade.php -->

@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/faq.js') }}" defer></script>
@endpush


    @section('navbar')
        <li><a><span>Option 1</span></a></li>
        <li><a><span>Option 2</span></a></li>
        <li><a><span>Option 3</span></a></li>
        <li><a><span>Option 4</span></a></li>
    @endsection


@section('content')



        <div>
            <h1>Some of the most frequently <br> asked questions</h1>
        </div>
        <!-- ... (rest of your content) ... -->

@endsection
