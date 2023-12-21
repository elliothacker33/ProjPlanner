@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endpush

@push('scripts')

    <script type="module" src="{{ asset('js/modal.js') }}" defer></script>
    <script type="module" src="{{ asset('js/editComment.js') }}" defer></script>
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

                @if($task->status == 'open') <span class="status open"> <i class="fa-solid fa-folder-open"></i> Open </span>
                @elseif($task->status == 'closed') <span class="status closed"> <i class="fa-solid fa-folder-closed"></i> Closed </span>
                @else <span class="status canceled"> <i class="fa-solid fa-ban"></i> Canceled </span>
                @endif
            </section>
            <section class="actions">
                @can('update', $task)
                    <a class="edit buttonLink" href="{{route('edit_task',['project'=>$project,'task'=>$task])}}"> <i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <a class="cancel buttonLink" id="openCancelModal"> <i class="fa-solid fa-ban"></i> Cancel</a>
                @endcan
            </section>
        </header>
        <section class="container">
            <section class="primaryContainer">

                <section class="description">
                    {{$task->description}}
                </section>

                @can('changeStatus', $task)
                    @if ($task->status != 'open')
                        <a class="buttonLink" id="openReopenModal"> <i class="fa-solid fa-folder-open"></i> Reopen task </a>
                    @else
                        <a class="buttonLink" id="openCloseModal"> <i class="fa-solid fa-folder-closed"></i> Close task </a>
                    @endif
                @endcan
            <div>
            <div class ="container-fluid containerBoot p-2">
                <div class = "row p-3">
            @forelse($comments as $comment)

            @if (Auth::user()->id == $comment->user_id)
                    <div class="own-comment col-12 p-4" id="{{$comment->id}}" style="margin-bottom: 10px;">
                @else
                    <div class="participants-comment col-12 p-4" style="margin-bottom: 10px;">
                @endif
                    <div class ="row">
                        <div class="comment-header col-12">
                              <div class="row">
                                    <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 userName">
                                    <img class="icon avatar" src="{{\App\Http\Controllers\FileController::get('user',$comment->user->id)?:asset('img/default_user.jpg') }}" alt="default user icon">
                                        <span>{{$comment->user->name}}</span>
                                    </div>
                                    @if (Auth::user()->id == $comment->user_id)
                                    <div class =" col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8  editButtons">
                                    <button class="edit-comment" style = "margin-right: 10px;"><i class="fas fa-edit"></i></button>
                                    <form action="{{route('delete_comment',['project'=>$project,'task'=> $task,'comment'=>$comment])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-comment" type="submit" style ="background-color:var(--error-text-color);"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    </div>
                                    @endif
                                </div>
                        </div>
                        <div class="comment-content col-12"> 
                            <div class="comment-body">
                                <p class="content">{{ $comment->content }}</p>
                            </div>
                            <div class="comment-footer d-flex justify-content-end">
                                <p class="date-post"> 
                                @if ($comment->last_edited !== null) 
                                    Last edited: {{ date('d-m-Y', strtotime($comment->last_edited)) }}
                                @else
                                    Posted: {{ date('d-m-Y', strtotime($comment->submit_date)) }}
                                @endif
                                </p>
                            </div>
                        </div>
                        </div>
                </div>
            @empty

            
            <span> No comments for this task.</span>
            @endforelse
            </div>
            </div>
            </div>
            <div class="new-comment">
            <form action= "{{ route('store_comment', ['project' => $project, 'task' => $task]) }}" method="POST">
                @csrf
                <div class="new-comment-body">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Write your comment here..."></textarea>
                </div>
               
                <div class="new-comment-footer">
                    <button type="submit">Comment</button>
                </div>
            </form>
        </div>
            </section>
            <section class="sideContainer">
                <section class="deadlineContainer" >
                    <span> <i class="fa-solid fa-clock"></i>
                        @if ($task->endtime == null)
                            Deadline:
                            @if ($task->deadline) {{ date('d-m-Y', strtotime($task->deadline)) }}
                            @else There is no deadline
                            @endif
                        @else
                            {{ ucwords($task->status) }} at:  {{ date('d-m-Y', strtotime($task->endtime)) }}
                        @endif
                    </span>
                </section>
                @if ($task->status != 'open')
                    <section id="finishedTaskUser">
                        <span><i class="fa-solid fa-user"></i> {{ ucwords($task->status) }} by: {{$task->closed_by->name}}</span>
                    </section>
                @endif
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
                <section class="taskCreator">
                    <span><i class="fa-solid fa-user"></i> Creator: {{$creator->name}}</span>
                </section>
            </section>
        </section>
    </section>
@endsection