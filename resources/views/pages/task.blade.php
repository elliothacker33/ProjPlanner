@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')
    <section class="taskCreation">

      {{$task}}

    </section>



@endsection