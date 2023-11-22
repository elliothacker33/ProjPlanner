@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush

@section('content')

    <section class="tasks-content">

        <div> 
            <input type="search" placeholder="Search" aria-label="Search" id="search-bar" />
            <a> <button data-mdb-ripple-init> Add a Task </button> </a>
        </div>

        <div class="tasks-list">

            <header> 
                <section class="task">Task</section> 
                <section class="status">Status</section>
            </header>
            <section class="tasks">

                @include('partials.displayTasks')

            </section>
        </div>
        
    </section>

@endsection