@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/task.js') }}" defer></script>
@endpush

@section('content')
    <section class="taskPage">
        <header>
            <section class="info">
            <h1 class="title">{{$task->title}}</h1>

            @if($task->status == 'open') <span class="status open"> Open </span>
            @elseif($task->status == 'closed') <span class="status closed"> Closed </span>
            @else <span class="status canceled"> Canceled </span>
            @endif
            </section>
            @can('update',$task)
                <section class="actions">
                    <a class="edit buttonLink">Edit</a>
                    <a class="cancel buttonLink" id="cancelTaskBtn" data-userid="{{ Auth::user()->id }}">Cancel</a>
                </section>
            @endcan

        </header>
        <section class="container">
            <section class="primaryContainer">

                <section class="description">
                    {{$task->description}}
                </section>

                <a class="buttonLink" id="closeTaskBtn" data-userid="{{ Auth::user()->id }}"> Close task </a>

            </section>
            <section class="sideContainer">
                <section class="deadlineContainer" >
                    <span>Deadline:
                        @if($task->deadline) {{ date('d-m-Y', strtotime($task->deadline)) }}
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