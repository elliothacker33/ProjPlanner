@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/static/home.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush

@section('content')
<header>
    <h1>
        Your Projects
    </h1>
</header>

<section class="projects">
    @foreach($projects as $project)
        <div class="project">
            <h2>Name: {{ $project->title }}</h2>
            <h2>Deadline: {{ $project->deadline->format('Y-m-d') }}</h2>
            <a href="{{ route('project', ['projectId' => $project->id]) }}"> Go to Project</a>
        </div>
    @endforeach
</section>

@endsection

