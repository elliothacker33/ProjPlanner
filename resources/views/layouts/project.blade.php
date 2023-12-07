@extends('layouts.app')

@section('navbar')
    <li><a href="{{route('project',['project'=>$project->id])}}">Project Home</a></li>
    <li><a href="{{route('team',['project'=>$project->id])}}">Team</a></li>
    <li><a href="{{route('show_tasks',['project'=>$project->id])}}">Tasks</a></li>
@endsection
