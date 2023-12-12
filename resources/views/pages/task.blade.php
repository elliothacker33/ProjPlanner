@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/task.js') }}" defer></script>
    <script type="module" src="{{ asset('js/modal.js') }}" defer></script>
@endpush

@section('content')
    <section class="taskPage">
        @include('partials.modal', [
            'modalTitle' => 'Close Task',
            'modalBody' => 'Are you sure that you want to mark this task as closed?',
            'actionId' => 'closeTaskBtn',
            'openFormId' => 'openCloseModal',
        ])
        @include('partials.modal', [
            'modalTitle' => 'Cancel Task',
            'modalBody' => 'Are you sure that you want to mark this task as canceled?',
            'actionId' => 'cancelTaskBtn',
            'openFormId' => 'openCancelModal',
        ])
        @include('partials.modal', [
            'modalTitle' => 'Reopen Task',
            'modalBody' => 'Are you sure that you want to mark this task as open?',
            'actionId' => 'reopenTaskBtn',
            'openFormId' => 'openReopenModal',
        ])
        <header>
            <section class="info">
            <h1 class="title">{{$task->title}}</h1>

            @if($task->status == 'open') <span class="status open"> Open </span>
            @elseif($task->status == 'closed') <span class="status closed"> Closed </span>
            @else <span class="status canceled"> Canceled </span>
            @endif
            </section>
            @can('changeStatus', $task)
                @if ($task->status == 'open')
                    <section class="actions">
                        <a class="edit buttonLink">Edit</a>
                        <a class="cancel buttonLink" id="openCancelModal">Cancel</a>
                    </section>
                @endif
            @endcan

        </header>
        <section class="container">
            <section class="primaryContainer">

                <section class="description">
                    {{$task->description}}
                </section>

                @can('changeStatus', $task)
                    @if ($task->status != 'open')
                        <a class="buttonLink" id="openReopenModal"> Reopen task </a> 
                    @else
                        <a class="buttonLink" id="openCloseModal"> Close task </a> 
                    @endif
                @endcan

            </section>
            <section class="sideContainer">
                <section class="deadlineContainer" >
                    @if ($task->endtime == null)
                        <span>Deadline:
                            @if($task->deadline) {{ date('d-m-Y', strtotime($task->deadline)) }}
                            @else There is no deadline
                            @endif
                        </span>
                    @else
                        <span>{{ ucwords($task->status) }} at:  {{ date('d-m-Y', strtotime($task->endtime)) }}</span>
                    @endif
                    
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