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
            <section class="userContainer">
            @foreach($users as $user)
                <div class="user"> 
                    <a href="/user-profile/{!! $user->id !!}"><section class="name"> {!! $user->name !!} </section></a>
                    <section class="email"> {!! $user->email !!} </section>
                    @if($user->is_admin)    
                        <section class="role"> Admin </section>
                    @else 
                        <section class="role"> User </section>  
                    @endif
                    <section class="change"> <a href="/admin/users/{!! $user->id !!}/edit"><button> Edit </button></a> </section>         
                    <section class="change"> <a href="/admin/users/{!! $user->id !!}/delete"><button> Delete </button></a>  </section>
                </div>
            @endforeach
            </section>
        </div>


    </section>
@endsection
