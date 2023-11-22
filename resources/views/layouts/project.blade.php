@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
@endpush


@section('navbar')
    <li><a href="/project/{!! $project->id !!}/">Project Home</a></li>
    <li><a>Team</a></li>
    <li><a href="/project/{!! $project->id !!}/tasks/">Tasks</a></li>
@endsection
