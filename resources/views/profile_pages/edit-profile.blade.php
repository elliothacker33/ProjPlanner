@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush
@section('content')
<div class="container-fluid">
	<div class="row first ">
	<div class="col-12 d-flex justify-content-between mt-5">
        <a href = "{{ route('profile', ['user' => Auth::user()]) }}" class =" goback  "> 
         Go back
        </a>
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
                <a href= "{{ route('edit_profile', ['user' => Auth::user()]) }}" class="dropdown-item editbutton">Edit Account</a>
            </li>
            <li>
                <a href= "" class="dropdown-item delete-btn">Delete Account</a>
            </li>
            </ul>
        </div>
    </div>
    <div class="col-12  mb-5">
        <div class = "row">
            <div class = " col-sm-12 col-lg-2 d-flex justify-content-center ">
                <figure>
                    <img src="{{ $image }}" alt="Default Image" >
                </figure>
            </div>
            <div class = "col-sm-12 col-lg-10   d-flex flex-column justify-content-center">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-3 col-sm-4 mx-auto text-center d-flex justify-content-center justify-content-lg-start">
                                <div class = "row">
                                    <div class = "col-12">
                                        <span class="infos">
                                            <i class="bi bi-person-fill"></i> Name
                                        </span>
                                    </div>
                                    <div class = "col-12">
                                        <span class="infos">
                                            {{$user->name}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 mx-auto text-center d-flex justify-content-center justify-content-lg-start">
                                <div class = "row">
                                    <div class = "col-12">
                                        <span class="infos">
                                            <i class="bi bi-person-fill"></i> Email
                                        </span>
                                    </div>
                                    <div class = "col-12">
                                        <span class="infos">{{$user->email}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 mx-auto text-center d-flex justify-content-center justify-content-lg-start">
                                <div class = "row">
                                    <div class = "col-12">
                                        <span class="infos">
                                            <i class="bi bi-person-fill"></i> Role
                                        </span>
                                    </div>
                                    <div class = "col-12">
                                        @if($user->is_admin)
                                            <span class="infos">Admin Account</span>
                                        @else <span class="infos">User Account</span>
                                        @endif
                                    </div>
                                </div>
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
            <div class ="row">
                <div class ="col-6">
                <header><h1> <i class="bi bi-pencil"></i> Edit your credentials</h1></header>
                </div>
            </div>
        </div>
        <div class = "col-12 ">
            <form method="POST" class ="row d-flex align-items-center" action="{{ route('update_profile', ['user' => Auth::user()])}}">
                @csrf()
                @method('PUT')
                <div class = "form-group col-4 mb-3">
                    <label for="name">Choose your name</label>
                    <input type="text" id = "name" name="name" placeholder="Choose your name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <span class="error">
                        {{ $errors->first('name') }}
                    </span>
                @endif
                </div>
                <div class = "form-group col-12 mb-3">
                    <label for="password">Enter your old password</label>
                    <input type="password" id = "old_password" name="old_password" placeholder="Old password">
                    @if ($errors->has('old_password'))
                    <span class="error">
                        {{ $errors->first('old_password') }}
                    </span>
                @elseif(session('error'))
                    <span class="error">
                        {{ session('error') }}
                    </span>
                @endif
                </div>
                <div class = "form-group col-12 mb-3">
                <label for="new_password">Choose your new password</label>
                <input type="password" id = "new_password" name="new_password" placeholder="New password">

                @if ($errors->has('new_password'))
                    <span class="error">
                        {{ $errors->first('new_password') }}
                    </span>
                @endif
                </div>
                <div class = " col-12 update ">
                <button><p>Update Profile</p></button>
                </div>
            </form>
        </div>
        <div class = "col-12 mb-5 ">
            <header><h1><i class="bi bi-sliders"></i>Change your profile image</h1></header>
        </div>
        <div class = "col-12 ">
        <form method="post" action="{{ route('upload_profile_file')}}" id="updateProfileForm" enctype="multipart/form-data" class=" row d-flex align-items-center">
            @csrf
            <div class="mb-3 col-12">
                <label for="profileImageInput" class="form-label">Choose Profile Image</label>
                <input type="file" name="file" id="profileImageInput">
            </div>
            <input name="id" type="number" value="{{Auth::id()}}" hidden>
            <input name="type" type="text" value="user" hidden>
            <div class = "col-12">
            <button type="submit">Update Profile Image</button>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </form>

        </div>
        <div class = "col-12">
            <form method="POST" action="{{ route('delete_file') }}">
            @csrf
            @method('DELETE')
            <input name="id" type="number" value="{{Auth::id()}}" hidden>
            <input name="type" type="text" value="user" hidden>
            <button type="submit" class = "buttonremove">Remove profile image</button>
            </form>
        </div>
</div>

</div>
    
@endsection

