@extends('layouts.project')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/team.css') }}">
@endpush

<section class="team">

    @can('update',[\App\Models\Project::class,$project])
        <section class="addUserContainer">
        <form method="POST" action="{{ route('addUser', ['project' => $project])  }}">
            {{ csrf_field() }}
            <input type="email" name="email" placeholder="User Email" required>

            <button type="submit" > Add </button>
        </form>
    </section>
    @endcan
    @if($errors->has('email'))
        <span class="error">
                        {{ $errors->first('email') }}
                    </span>
    @endif
    <h2>Projects Member</h2>
    <section class="teamContainer">
        @foreach($team as $member)
            <section class="member">
                <p>{{$member->name}}</p>
                <p>{{$member->email}}</p>
            </section>
        @endforeach

    </section>




</section>