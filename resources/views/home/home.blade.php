@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<header id="my-projects-header">
    <h1>
        Your Projects
    </h1>
    <a class="button" href="{{ route('show_new') }}" >Create a project</a>
</header>

<section class="projects">
    @if (!isset($projects))
        <div class="project" style="text-align: center"> <h2>You have no projects for now</h2> </div>
    @else
        @foreach($projects as $project)
            <div class="project">
                <h2>Name: {{ $project->title }}</h2>
                <h2>Deadline: {{ $project->deadline->format('Y-m-d') }}</h2>
                <a href="{{ route('project', ['projectId' => $project->id]) }}"> Go to Project</a>
            </div>
        @endforeach
    @endif
</section>

@endsection

