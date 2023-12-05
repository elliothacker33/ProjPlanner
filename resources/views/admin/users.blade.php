@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/admin/users.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/admin.js') }} defer></script>
@endpush

@section('content')
    <section class="admin-content">
        
        <h2 class="shine"> Admin Page </h2>

        <div> 
            <input type="search" placeholder="Search" aria-label="Search" id="search-bar" />
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

                @include('partials.displayUsers')

            </section>
        </div>
    </section>
@endsection
