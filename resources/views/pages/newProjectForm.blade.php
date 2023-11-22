@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">

@endpush

@section('content')
    <section class="projectCreation">
        <section class="formContainer">
            <header class="tasks">
                <h2>Create a <span class="shine">Project</span></h2>
            </header>
            <form method="POST">
                @csrf
                <section class="primaryContainer">
                    <input type="text" name="title" placeholder="Project's Title" value="{{ old('title') }}" required>

                    @if ($errors->has('title'))
                        <span class="error">
                            {{ $errors->first('title') }}
                        </span>
                    @endif

                    @if (old('description') != null)
                        <textarea name="description" placeholder="Project's Description">{{ old('description') }}</textarea>
                    @else
                        <textarea name="description" placeholder="Project's Description"></textarea>
                    @endif

                    @if ($errors->has('description'))
                        <span class="error">
                            {{ $errors->first('description') }}
                        </span>
                    @endif

                    <label for="deadline">
                        Deadline
                    </label>
                    <input type="date" name="deadline" id="deadline" value = "{{ old('deadline') }}">

                    @if ($errors->has('deadline'))
                        <span class="error">
                            {{ $errors->first('deadline') }}
                        </span>
                    @endif

                    <section class="buttons">
                        <button type="submit">
                            Create
                        </button>
                        <a href="{{ URL::previous() }}">
                            Cancel
                        </a>
                    </section>
                </section>                    
            </form>
        </section>
    </section>

@endsection
