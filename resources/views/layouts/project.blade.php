@extends('layouts.app')

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush


@section('navbar')
    <li><a href="{{route('project',['project'=>$project->id])}}"> <i class="fa-solid fa-house"></i> Project Home</a></li>
    <li><a href="{{route('team',['project'=>$project->id])}}"> <i class="fa-solid fa-users"></i> Team</a></li>
    <li><a href="{{route('show_tasks',['project'=>$project->id])}}"> <i class="fa-solid fa-list-check"></i> Tasks</a></li>
@endsection
