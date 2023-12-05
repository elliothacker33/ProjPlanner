@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    <script type="text/javascript" src="{{ asset('js/project.js') }}" defer></script>
@endpush

@section('content')
<section class="projectPage">
    <header>
        <h1 class="title">{{$project->title}}</h1>
        @if($project->is_archived) <span class="status archive"> Archive </span>
        @else <span class="status open"> Open </span>
        @endif

        @if($project->user_id===Auth::id())
            <!--<a class="edit">Edit</a>-->
            <button class="project-action-button" id="edit-project-button">Edit</button>
        @endif

        @can('delete', $project)
            <button class="project-action-button" id="delete-project-button">Delete</button>
        @endcan

        <!-- Hidden forms to actions in project page that don't use AJAX-->
        <form class="hidden-form" id="edit-project-form" action="{{ "/project/" . $project->id . "/edit"}}" method="GET">
        </form>

        <form class="hidden-form" id="delete-project-form" action="{{ "/project/" . $project->id }}" method="POST">
            @csrf
            @method('DELETE')
        </form>

    </header>
    <section class="container">
    <section class="primaryContainer">

        <section class="description">
            {{$project->description}}
        </section>

    </section>
    <section class="sideContainer">
        <section class="completionContainer">
            <span class="completion">Completed Tasks {{$completedTasks}}/{{$allTasks}}</span>
        </section>
        <section class="deadlineContainer" >
            <span>Deadline:
                @if($project->deadline) {{ date('d-m-Y', strtotime($project->deadline)) }}
                @else There is no deadline
                @endif

            </span>
        </section>
        <section class="teamContainer">
            <h5>Team: </h5>
            <ul class="team">
                @foreach($team as $member)
                    <li>{{$member->name}}</li>
                @endforeach
            </ul>
            <a >See all</a>
        </section>
    </section>
    </section>
</section>
@endsection