@php use App\Models\Project; @endphp
@extends('layouts.project')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">

@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/pages/user.js') }}" defer></script>
@endpush

@section('content')
    <section class="team">


        <section class="users-list">
            <header>
                <section class="search">
                    <input type="search" placeholder="&#128269 Search" aria-label="Search" id="search-bar"/>

                </section>
                <section>
                    <span> <i class="fa-solid fa-users"></i>  {{count($team)}} Members </span>
                    @can('update',[Project::class,$project])
                        <section class="addUserContainer">
                            <form method="POST" action="{{ route('addUser', ['project' => $project])  }}">
                                {{ csrf_field() }}
                                <input type="email" name="email" placeholder="New member Email" required
                                       value="{{old('email')}}">

                                <button type="submit"><i class="fa-solid fa-user-plus"></i> Add member</button>
                            </form>
                            @if ($errors->has('email'))
                                <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                            @endif
                        </section>
                    @endcan
                </section>
            </header>
            <section class="users">
                <form class="hidden" id="assign-coordinator-form" method="POST">
                    @csrf
                    @method('PUT')
                </form>
                @foreach($team as $user)
                    <section class="user-item">
                        <section class="userSection">

                            <a href="{{route('profile',['user'=>$user])}}">
                                @include('partials.userCard',['user'=>$user, 'size'=>'.median'])
                            </a>

                        </section>
                        @if($project->user_id === $user->id)
                            <span class="status coordinator"> <i class="fa-solid fa-user-tie"></i> Coordinator</span>
                        @else
                            <span class="status member"> <i class="fa-solid fa-user"></i> Member</span>
                        @endif
                        @can('update', [Project::class,$project])
                            <section class="actions">
                                @if($project->user_id !== $user->id )
                                    <button class="promote" name="user_id" value="{{ $user->id }}" type="submit" form="assign-coordinator-form" formaction="{{ route('assign_coordinator', ['project' => $project->id])}}">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </button>
                                    <span class="remove" id="{{$user->id}}"><i
                                                class="fa-solid fa-user-xmark"></i></span>
                                @endif
                            </section>
                        @endcan
                    </section>
                @endforeach
            </section>
        </section>


    </section>
@endsection