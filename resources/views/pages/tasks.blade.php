@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/pagination.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/tasks.js') }}" defer></script>
@endpush

@section('content')

    <section class="tasks-content">
        
        <section class="tasks-list">
            <header>
                <section class="search">

                    <form method="GET" id="search" action="{{route('show_tasks',['project'=>$project])}}">
                        <input type="search" name="query" placeholder="&#128269 Search" aria-label="Search"
                               id="search-bar" value="{{$query}}"/>
                        <button class="" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>

                    </form>
                </section>
                <section>
                    <span>
                        <span class="status open">
                            <i class="fa-solid fa-folder-open"></i>
                            {{$open}} Open
                        </span>
                    </span>
                    <span>
                        <span class="status closed">
                            <i class="fa-solid fa-folder-closed"></i>
                            {{$closed}} Closed
                        </span>
                    </span>
                    <span>
                        <span class="status cancelled">
                            <i class="fa-solid fa-ban"></i>
                            {{$canceled}} Cancelled
                        </span>
                    </span>
                    <a class="button" href="{{ route('createTask', ['project' => $project]) }}"> + Add a Task </a>
                </section>
            </header>
            <section class="tasks">
                @foreach($tasks as $task)
                    @include('partials.taskCard',['task'=>$task])

                @endforeach

            </section>

        </section>
        @include("partials.paginator",['paginator'=>$tasks])

    </section>

@endsection