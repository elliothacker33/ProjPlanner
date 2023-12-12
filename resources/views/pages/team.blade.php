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
        <a class="button" href="{{ route('createTask', ['project' => $project]) }}"> Add a Task  </a>
    </section>

    <section class="users-list">
        <header>
            <span> <i class="fa-solid fa-users"></i>  {{count($team)}} Members </span>

        </header>
        <section class="users">

            <section class="user-item">
                <section class="user">
                @foreach($team as $user)
                    @include('partials.userCard',['user'=>$user, 'size'=>'.median'])
                    <span class="status coordinator"> Coordinator</span>
                @endforeach
                </section>
                <section class="actions">
                    <i class="fa-solid fa-user-minus"></i>
                </section>
            </section>
        </section>
    </section>




</section>
@endsection