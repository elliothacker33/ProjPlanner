@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush

@section('content')
    <section class="taskPage">
        <header>
            <h1 class="title">{{$task->title}}</h1>
            @if($task->status == 'open') <span class="status open"> Open </span>
            @elseif($task->status == 'closed') <span class="status closed"> Closed </span>
            @else <span class="status cancelled"> Cancelled </span>
            @endif
            @can('update',$task)
                <section>

                    <a class="edit">Edit</a>
                </section>
            @endcan

        </header>
        <section class="container">
            <section class="primaryContainer">

                <section class="description">
                    {{$task->description}}
                </section>

            </section>
            <section class="sideContainer">
                <section class="deadlineContainer" >
                    <span>DeadLine:
                        @if($task->deadline) {{$task->deadline}}
                        @else There is no deadline
                        @endif
                    </span>
                </section>
                <section class="assignContainer">
                    <h5>Assigned: </h5>
                    <ul class="assign">
                        @foreach($assign as $user)
                            <li>{{$user->name}}</li>
                        @endforeach
                    </ul>
                </section>
                <section class="tagsContainer">
                    <h5>Tags: </h5>
                    <ul class="tags">
                        @foreach($tags as $tag)
                            <li>{{$tag->title}}</li>
                        @endforeach
                    </ul>
                </section>
                <section class="taskCreator">
                    <span>Creator: {{$creator->name}}</span>
                </section>
            </section>
        </section>
    </section>
@endsection