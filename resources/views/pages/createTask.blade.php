@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')
    <section class="taskCreation">

        <section class="formContainer">
            <header class="tasks">
                <h2>Create a <span class="shine">Task</span></h2>
            </header>
            <form method="POST" action="{{ route('newTask', ['projectId' => $projectId])  }}">
                @csrf
                <section class="primaryContainer">
                    <input type="text" name="title" placeholder="Task Title" required>
                    <textarea name="description" placeholder="Task Description"></textarea>
                    <section class="buttons">
                        <button type="submit">
                            Create
                        </button>
                        <a >
                            Cancel
                        </a>
                    </section>
                </section>
                <section class="sideContainer">
                    <label for="users">
                        Deadline
                    </label>
                    <input type="date" name="deadline">
                    <label for="users">
                        Assign User
                    </label>

                    <select name="users" >
                        <option selected="selected"> </option>

                        @foreach($users as $user )
                            <option value="{{$user->id}}"> {{$user->name}} </option>
                        @endforeach
                    </select>

                    <label>
                        Choose a tag
                    </label>
                    <select name="tags" >
                        <option>User 1</option>
                        <option>User 2</option>
                        <option>User 3</option>
                    </select>


                </section>
            </form>

        </section>

    </section>



@endsection