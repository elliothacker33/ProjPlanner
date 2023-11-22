@extends('layouts.app')

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush


@section('navbar')
    <li><a href="/project/{!! $project->id !!}/">Project Home</a></li>
    <li><a>Team</a></li>
    <li><a href="/project/{!! $project->id !!}/tasks/">Tasks</a></li>
@endsection
