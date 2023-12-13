@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@push('scripts')
    <script type="module" src={{ url('js/app.js') }} defer></script>
    <script type="module" src={{ url('js/task.js') }} > </script>
@endpush

@section('content')

    <section class="taskCreation">

        <section class="formContainer">
            <header class="tasks">
                <h2>Create a <span class="shine">Task</span></h2>
            </header>
            <form method="POST" action="{{ route('newTask', ['project' => $project])  }}" id="create_task">
                @csrf
                <section class="primaryContainer">
                    <input type="text" name="title" placeholder="Task Title" required value="{{ old('title') }}">
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


                </section>
                <section class="sideContainer">
                    <label for="deadline" >
                        <i class="fa-solid fa-clock"></i> Deadline
                    </label>
                    <input id = "deadline" type="date" name="deadline" value="{{ old('deadline') }}">
                    @if ($errors->has('deadline'))
                        <span class="error">
                            {{ $errors->first('deadline') }}
                        </span>
                    @endif

                    @include('partials.multiselector',["data"=>"users"])

                    @include('partials.multiselector',["data"=>"tags"])
                    @if ($errors->has('tags'))
                        <span class="error">
                            {{ $errors->first('tags') }}
                        </span>
                    @endif

                </section>

                <input type="hidden" name ='users' id="assigns" value="">
                <input type="hidden" name ='tags' id="tags" value="">
            </form>
            <section class="buttons">
                <button type="submit" form="create_task">
                    Create
                </button>
                <a href="{{route('show_tasks',['project'=>$project])}}">
                    Cancel
                </a>
            </section>

        </section>

    </section>



@endsection