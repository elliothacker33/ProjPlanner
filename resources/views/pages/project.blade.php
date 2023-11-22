@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush
@section('content')
<section class="projectPage">
    <header>
        <h1 class="title">{{$project->title}}</h1>
        @if($project->is_archived) <span class="status archive"> Archive </span>
        @else <span class="status open"> Open </span>
        @endif
        @can('edit',$project)
            <a class="edit">Edit</a>
        @endcan

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
            <span>DeadLine: {{$project->deadline}}</span>
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