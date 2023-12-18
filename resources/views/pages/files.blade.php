@extends('layouts.project')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/files.css') }}">
@endpush
@section('content')
<div class = "container-fluid">
    <div class = "row first">
        <div class = "col-12">
            <div class = "row main-header">
                <div class = "col-4 test1">
                        <header>
                            <h1> Files : {{$project->title}}</h1> 
                        </header>
                </div>
                <div class = "col-8 d-flex justify-content-end align-items-center p-4 options">

                <a href="#" class="btn btn-link dl" download><i class="bi bi-download"></i> Download all</a>
                <a href ="#" class ="btn btn-link ra"> <i class="bi bi-trash-fill"></i> Remove all</a>
                <form action="{{ route('upload_file') }}" method="post" enctype="multipart/form-data">
                        @csrf()
                        <input type="file" name="files" id="files" multiple>
                        <input name="id" type="number" value="{{$project->id}}" hidden>
                        <button type="submit" ></button>
                </form>
                </div>
            </div>
        </div>
        

        <div class = "col-12">
            <div class ="row">
                <div class ="col-12 file p-4">
                    <div class ="row">
                        <div class ="col-3 file-title d-flex justify-content-center align-items-center">
                            <h2>
                                Python eating a capybara in a jungle
                            </h2>
                        </div>
                        <div class ="col-3 d-flex file-size justify-content-center align-items-center">
                            <span>
                                127kb
                            </span>
                        </div>
                        <div class ="col-3 d-flex justify-content-center align-items-center">
                            12/31/2017
                        </div>
                        <div class ="col-3 d-flex justify-content-end align-items-center p-3">
                        <a href="#" class="btn btn-link" download><i class="bi bi-download dl2"></i></a>
                        <a href ="#" class ="btn btn-link"> <i class="bi bi-trash-fill rm"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection