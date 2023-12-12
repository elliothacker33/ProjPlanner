@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endpush

@section('content')
    <section class="taskPage">
        <header>
            <section class="info">
            <h1 class="title">{{$task->title}}</h1>

            @if($task->status == 'open') <span class="status open"> <i class="fa-solid fa-folder-open"></i> Open </span>
            @elseif($task->status == 'closed') <span class="status closed"> <i class="fa-solid fa-folder-closed"></i> Closed </span>
            @else <span class="status cancelled"> <i class="fa-solid fa-ban"></i> Cancelled </span>
            @endif

            <h6>#{{$task->id}} Created by {{$task->creator->name}} on {{ date('d-m-Y', strtotime($task->starttime)) }}</h6>
            </section>
            @can('update',$task)
                <section class="actions">

                    <a class="edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <a class="delete"> <i class="fa-solid fa-trash"></i> Delete</a>
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
                    <span> <i class="fa-solid fa-clock"></i> Deadline:
                        @if($task->deadline) {{ date('d-m-Y', strtotime($task->deadline)) }}
                        @else There is no deadline
                        @endif
                    </span>
                </section>
                <section class="assignContainer">
                    <h5><i class="fa-solid fa-users"></i> Assigned: </h5>
                    <ul class="assign">
                        @foreach($assign as $user)
                            <li>{{$user->name}}</li>
                        @endforeach
                    </ul>
                </section>
                <section class="tagsContainer">
                    <h5><i class="fa-solid fa-tag"></i> Tags: </h5>
                    <ul class="tags">
                        @foreach($tags as $tag)
                            <li>{{$tag->title}}</li>
                        @endforeach
                    </ul>
                </section>
            </section>
        </section>
    </section>
@endsection