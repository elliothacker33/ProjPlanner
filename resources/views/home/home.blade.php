@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/projects.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/snackbar.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/pages/projects.js') }}" defer></script>

    <script type="module" src="{{ asset('js/snackbar.js') }}" defer></script>

    <script type="module" src="{{ asset('js/favorites.js') }}" defer></script>

@endpush

@section('content')
    <section class="projectPage">
        <section class="project-list">
            <header>
                <section class="search">

                    <form method="GET" id="search" action="{{route('projects')}}">
                        <input type="search" name="query" placeholder="&#128269 Search" aria-label="Search"
                               id="search-bar" value="{{$query}}"/>
                        <button class="" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>

                    </form>
                </section>
                <section>
                    <h5>
                        <i class="fa-solid fa-folder-closed"></i> My Projects:  {{count($projects)}}
                    </h5>
                    <a class="button" href="{{ route('show_new') }}"> <i class="fa-solid fa-folder-plus"></i> Add a Project </a>
                </section>
            </header>
            <section class="projects">
                @foreach($projects as $project)
                    @include("partials.projectCard",['$project'=>$project])
                    

                @endforeach

            </section>

        </section>
        @include("partials.paginator",['paginator'=>$projects])
        @isset($message)
            @include("partials.snackbar", ['type' => $message[0], 'content' => $message[1]])
        @endisset
    </section>

@endsection