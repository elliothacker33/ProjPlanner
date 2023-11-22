@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
@endpush


@section('navbar')
    <li><a>Project Home</a></li>
    <li><a>Team</a></li>
    <li><a>Tasks</a></li>

@endsection

