@extends('layouts.app')

@section('navbar')
    <li id="projectHome"><a href="{{route('project',['project'=>$project->id])}}"> <i class="fa-solid fa-house"></i> Project Home</a></li>
    <li id="projectTeam"><a href="{{route('team',['project'=>$project->id])}}"> <i class="fa-solid fa-users"></i> Team</a></li>
    <li id="projectTasks"><a href="{{route('show_tasks',['project'=>$project->id])}}"> <i class="fa-solid fa-list-check"></i> Tasks</a></li>
    <li id="projectBoard"><a href="{{route('board',['project'=>$project->id])}}"> <i class="bi bi-kanban-fill"></i> Board</a></li>
@endsection
