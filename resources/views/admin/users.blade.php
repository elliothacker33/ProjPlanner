@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/admin/users.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <link href="{{ asset('js/admin.js') }}" defer>
@endpush

@section('content')
    <section class="admin-content">

        <h2 class="shine"> Admin Page </h2>

        <div> 
            <input type="search" placeholder="Search" aria-label="Search" />
            <a href="{{ route('admin_user_create') }}"> <button data-mdb-ripple-init> Add a User </button> </a>
        </div>

        <div class="admin-users">

            <header> 
                <section class="name">Users</section> 
                <section class="email">Email</section>
                <section class="role">Role</section>
                <section class="change">Edit</section>
                <section class="change">Delete</section>
            </header>

            @php

                
                use App\Models\User;
                $users = User::all();

                foreach($users as $user) {
            @endphp
                    <div class="user"> 
                        <section class="name"> {!! $user->name !!} </section>
                        <section class="email"> {!! $user->email !!} </section>
            @php
                    if($user->is_admin == True) {
            @endphp
                        <section class="role"> Admin </section>
            @php
                    } else {
            @endphp
                        <section class="role"> User </section>  
            @php 
                    }
            @endphp
                        <section class="change"> <a href="/admin/users/{!! $user->id !!}/edit"><button> Edit </button></a> </section>         
                        <section class="change"> <a href="/admin/users/{!! $user->id !!}/delete"><button> Delete </button></a>  </section>
                    </div>
            @php
                }

            @endphp
        </div>


    </section>
@endsection
