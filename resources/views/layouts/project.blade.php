@extends('layouts.app')

@section('navbar')
    <li><a href="/project/{!! $project->id !!}/">Project Home</a></li>
    <li><a href="/project/{!! $project->id !!}/team">Team</a></li>
    <li><a href="/project/{!! $project->id !!}/tasks/">Tasks</a></li>
@endsection
