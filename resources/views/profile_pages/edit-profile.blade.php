@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush
@section('content')
<div class="container-fluid">
	<div class="row first">
	<div class="col-12 d-flex justify-content-between mb-5">
        <a href = "{{ route('profile', ['usrId' => Auth::id()]) }}" class =" goback  "> 
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
                <a href= "{{ route('edit_profile', ['usrId' => $usrId]) }}" class="dropdown-item editbutton">Edit Account</a>
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
                    <img src="{{ asset('img/default-profile-photo.jpg') }}" alt="Default Image" >
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
                                            {{$profileName}}
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
                                        <span class="infos">{{$profileEmail}}</span>
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
                                        @if($isAdmin)
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
                <div class = "col-6 d-flex  forgot justify-content-end">
                    <a href=""> Forgot your password? </a>
                </div> 
            </div>
        </div>
        <div class = "col-12">
            <form method="POST" class ="row d-flex align-items-center" action="{{ route('update_profile', ['usrId' => $usrId])}}">
                @csrf()
                @method('PUT')
                <div class = "form-group col-12 mb-3">
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
                <div class = " col-12 ">
                <button><p>Update Profile</p></button>
                </div>
            </form>
        </div>
        <div class = "col-12 mb-5 ">
            <header><h1><i class="bi bi-sliders"></i> Change your profile image</h1></header>
        </div>
        <div class = "col-12 ">
            <form  method="POST" action="{{ route('update_profile', ['usrId' => $usrId])}}" id="updateProfileForm" enctype="multipart/form-data" class="class =row d-flex align-items-center">
                @csrf
                @method('PUT') 
                <div class="mb-3">
                    <label for="profileImageInput" class="form-label">Choose Profile Image</label>
                    <input type="file" name="profile_image" id="profileImageInput">
                </div>
                <button type="submit">Update Profile Image</button>
            </form>
        </div>
</div>

</div>
    
@endsection

<!-- <header>
        <h1>Edit Profile</h1>
    </header>
    <figure>
        <img src="{{ asset('img/default-profile-photo.jpg') }}" alt="Default Image">
    </figure>
    <form method="POST" action="{{ route('update_profile', ['usrId' => $usrId])}}">
        @csrf()
        @method('PUT')
        <input type="text" name="name" placeholder="Choose your name" value="{{ old('name') }}">

        @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
        @endif


        <input type="password" name="old_password" placeholder="Old password">

        @if ($errors->has('old_password'))
            <span class="error">
                {{ $errors->first('old_password') }}
            </span>
        @elseif(session('error'))
            <span class="error">
                {{ session('error') }}
            </span>
        @endif

        <input type="password" name="new_password" placeholder="Choose new password">

        @if ($errors->has('new_password'))
            <span class="error">
                {{ $errors->first('new_password') }}
            </span>
        @endif

        <button><p>Update Profile</p></button>
    </form> -->
    