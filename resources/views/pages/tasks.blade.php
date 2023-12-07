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
        <div> 
            <input type="search" placeholder="Search" aria-label="Search" id="search-bar" />
            <a class="button" href="{{ route('createTask', ['project' => $project]) }}"> Add a Task  </a>
        </div>

        <div class="tasks-list">

            <section class="tasks">
                @foreach($tasks as $task)
                    @include('partials.taskCard',['task'=>$task])

                @endforeach

            </section>
        </div>

        
    </section>


@endsection