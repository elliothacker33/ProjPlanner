@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/tasks.js') }}" defer></script>
@endpush

@section('content')

    <section class="tasks-content">
        <section class="search">
            <input type="search" placeholder="Search" aria-label="Search" id="search-bar" />
            <a class="button" href="{{ route('createTask', ['project' => $project]) }}"> Add a Task  </a>
        </section>

        <section class="tasks-list">
            <header>
                <span><span class="status open"> <i class="fa-solid fa-folder-open"></i> {{$open}} Open </span>  </span>
                <span> <span class="status closed"> <i class="fa-solid fa-folder-closed"></i> {{$closed}} Closed </span>  </span>
                <span> <span class="status cancelled"> <i class="fa-solid fa-ban"></i> {{$canceled}} Cancelled </span>  </span>
            </header>
            <section class="tasks">
                @foreach($tasks as $task)
                    @include('partials.taskCard',['task'=>$task])

                @endforeach

            </section>
        </section>

        
    </section>


@endsection