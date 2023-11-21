@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/admin/admin_users.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <link href="{{ asset('js/admin.js') }}" defer>
@endpush

@section('content')
    <section class="admin-content">

        <h2 class="shine"> Admin Page </h2>

        <div class="admin-users">
            <header> 
                <section class="name">Users</section> 
                <section class="email">Email</section>
                <section class="change">Edit Delete</section>
            </header>
            @php
                use App\Models\User;
                $users = User::all();

                foreach($users as $user) {

            @endphp
                <div> 
                    <section class="name"> {!! $user->name !!} </section>
                    <section class="email"> {!! $user->email !!} </section>
                    <section class="change"> <a href="/admin/users/{!! $user->id !!}/edit"> Edit </a>  <a href="/admin/users/{!! $user->id !!}/delete"> Delete </a>  </section>
                </div>
            @php
                }

            @endphp
        </div>


    </section>
@endsection
