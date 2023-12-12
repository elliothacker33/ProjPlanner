@extends('layouts.project')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/team.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/tasks.js') }}" defer></script>
@endpush

@section('content')
<section class="team">

    <section class="search">
        <input type="search" placeholder="Search" aria-label="Search" id="search-bar" />
    </section>

    <section class="users-list">
        <header>
            <span> <i class="fa-solid fa-users"></i>  {{count($team)}} Members </span>
            @can('update',[\App\Models\Project::class,$project])
                <section class="addUserContainer">
                    <form method="POST" action="{{ route('addUser', ['project' => $project])  }}">
                        {{ csrf_field() }}
                        <input type="email" name="email" placeholder="New member Email" required>

                        <button type="submit" > Add member </button>
                    </form>
                </section>
            @endcan
        </header>
        <section class="users">
            @foreach($team as $user)
            <section class="user-item">
                <section class="user">

                    <a href="">
                    @include('partials.userCard',['user'=>$user, 'size'=>'.median'])
                    </a>
                    @if($project->user_id === $user->id)<span class="status coordinator"> Coordinator</span>
                    @else <span class="status member"> Member</span>
                    @endif


                </section>
                <section class="actions">
                    <span class="promote" id="{{$user->id}}"><i class="fa-solid fa-user-tie"></i></span>
                    <span class = "delete" id="{{$user->id}}"><i class="fa-solid fa-user-xmark"></i></span>

                </section>
            </section>
            @endforeach
        </section>
    </section>




</section>
@endsection