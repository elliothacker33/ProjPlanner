@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/team.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">

@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/pages/user.js') }}" defer></script>
@endpush

@section('content')
    <section class="adminPage">


        <form method="POST" class="hidden" id="delete" >
            @csrf
            @method("DELETE")
        </form>
        <section class="users-list">
            <header>
                <section class="search">
                    <input type="search" placeholder="&#128269 Search" aria-label="Search" id="search-bar" />

                </section>
                <section>
                <span> <i class="fa-solid fa-users"></i>  {{count($users)}} Users </span>
                <a class="button"href="{{route('admin_user_create')}}"><i class="fa-solid fa-user-plus"></i> Add user</a>
                </section>
            </header>
            <section class="users">
                @foreach($users as $user)
                    <section class="user-item">
                        <section class="userSection">

                            <a href="{{route('profile',['user'=>$user])}}">
                                @include('partials.userCard',['user'=>$user, 'size'=>'.median'])
                            </a>



                        </section>
                        @if($user->is_admin)<span class="status admin"> <i class="fa-solid fa-user-gear"></i> Admin</span>
                        @else <span class="status user"> <i class="fa-solid fa-user"></i> User</span>
                        @endif
                        @can('update', [\App\Http\Controllers\User::class,$user])
                            <section class="actions">
                                <a href="{{route("edit_profile",['user'=>$user])}}" class="edit" id="{{$user->id}}"><i class="fa-solid fa-user-pen"></i></a>
                                <button class = "block invisible" id="{{$user->id}}" form="block-{{($user->id)}}"><i class="fa-solid fa-ban"></i></button>
                                <button class = "delete invisible" id="{{$user->id}}"form="delete" formaction="{{route("delete_user",["user"=>$user])}}"><i class="fa-solid fa-trash"></i></button>
                                <form class="hidden" id ="block-{{($user->id)}}" action=""></form>

                            </section>
                        @endcan
                    </section>
                @endforeach
            </section>
        </section>




    </section>
@endsection