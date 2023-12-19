@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/forum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
@endpush

@section('content')

    <section class="edit-post">

        <div class="edit-post-container">
            <form action="{{ route('action_edit_post', ['project' => $project->id, 'post' => $post->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="edit-post-body">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Write your post here...">{{ $post->content }}</textarea>
                </div>
                <div class="edit-post-footer">
                    <button type="submit">Edit</button>
                </div>
            </form>
        </div>

    </section>

@endsection
