@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')

<div class="container-fluid">
	<div class="row first">
	<div class="col-12 d-flex justify-content-between mb-5">
        <header>
            <h1>User Details</h1>
        </header>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Options
            </button>
            <ul class="dropdown-menu p-4">
            <li>
                <h6 class="dropdown-header">Profile Actions</h6>
            </li>
            <li>
                <a href= "{{ route('edit_profile', ['usrId' => $usrId]) }}" class="dropdown-item editbutton">Edit Account</a>
            </li>
            <li>
                <a href= "" class="dropdown-item delete-btn">Delete Account</a>
            </li>
            </ul>
        </div>
    </div>
    <div class="col-12 mb-5">
        <div class = "row">
            <div class = "col-2">
                <figure>
                    <img src="{{ asset('img/team-avatars/4.jpeg') }}" alt="Default Image" >
                </figure>
            </div>
            <div class = "col">
                <div class="row">
                    <div class="col-12 ">
                        <span class = "infos"> <i class="bi bi-person-fill"></i> Name</span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-12 ">
                        <span class= "infos">{{$profileName}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row ">
                            <div class="col-3">
                                <span class="infos">
                                    <i class="bi bi-gear-fill"></i> Role
                                </span>
                            </div>
                            <div class="col-3">
                                <span class="infos">
                                    <i class="bi bi-envelope-fill"></i> Email
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!-- Second row -->
                    <div class="col-12 ">
                        <div class="row">
                            <div class="col-3">
                                @if($isAdmin)
                                    <span class="infos">Admin Account</span>
                                @else <span class="infos">User Account</span>
                                @endif
                            </div>
                            <div class="col-3">
                                <span class="infos">{{$profileEmail}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class ="row second">

        <div class = "col-12 mb-5 ">
            <header><h1>Quick tasks access</h1></header>
        </div>

    <div class = "col-12 mb-5">
        <div class ="row">
        @foreach($tasks as $task)
            <div class="col-12 mb-4">
                <div class = "row p-3 task">
                    <div class ="col-3 taskinfo">
                        <span class="text-truncate">
                            {{$task->title}} - {{$task->description}}
                        </span>
                    </div>
                    <div class="col-3 taskinfo">
                        <span><i class="bi bi-calendar-week"></i> {{ \Carbon\Carbon::parse($task->deadline)->format('Y/m/d') }}</span>
                    </div>
                    <div class ="col-3 taskinfo ">
                    @if($task->status == "closed")
                        <span>Status:</span>
                        <span style="color: #ff3333;">{{ $task->status }}</span>
                    @elseif($task->status == "canceled")
                        <span>Status: </span>
                        <span style="color: orange;">{{ $task->status }}</span>
                    @elseif($task->status == "open")
                        <span>Status: </span>
                        <span style="color: #2E9D7F;"> {{ $task->status }}</span>
                    @else
                        <span>{{ $task->status }}</span>
                    @endif
                    </div>
                    <div class="col-3">
                        <a href="" class = "btn taskbtn" >Go to Task</a>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <div class="col-12 mb-5">
        <header>
            <h1>Task Statistics</h1>
        </header>
	</div>

    <div class="col-12">
        <div class = "row">
            <div class = "col-4">
                <div class ="row">
                    <div class="col-12 text-center">
                        <span class="statNumber">{{$statusOpenCount = $tasks->where('status', 'open')->count()}}</span>
                    </div>
                    <div class="col-12 text-center">
                        <span class="statInfo">Open Tasks</span></div>
                    </div>
            </div>
            <div class = "col-4">
                <div class ="row">
                    <div class="col-12 text-center">
                        <span class="statNumber">{{$statusCanceledCount = $tasks->where('status', 'canceled')->count()}}</span>
                    </div>
                    <div class="col-12 text-center">
                        <span class="statInfo">Canceled Tasks</span></div>
                </div>
            </div>
            <div class = "col-4">
                <div class ="row">
                    <div class="col-12 text-center">
                        <span class="statNumber">{{$statusClosedCount = $tasks->where('status', 'closed')->count()}}</span>
                    </div>
                    <div class="col-12 text-center">
                        <span class="statInfo">Closed Tasks</span></div>
                    </div>
                </div>
            </div>
	    </div>
    </div>
</div>

@endsection
