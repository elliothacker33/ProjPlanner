@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/forum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
@endpush

@section('content')

    <section class="forum">

        <div class="forum-container">
            @if ($posts === null)
                <div class="no-posts">
                    <p>There are no posts yet.</p>
                </div>
            @else
                @foreach ($posts as $post)
                    @if (Auth::user()->id == $post->user_id)
                        <div class="own-post">
                        @else
                            <div class="participants-post">
                    @endif
                    <div class="post-header">
                        <div class="post-user">
                            @include('partials.userCard', ['size' => 'small', 'user' => $post->user])
                        </div>
                        @if (Auth::user()->id === $post->user_id)
                            <div class="post-edit">
                                <button class="edit-post"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('delete_post', ['post' => $post]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-post" type="submit"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="post-body">
                        <p>{{ $post->content }}</p>
                    </div>
                    <div class="post-footer">
                        <p class="date-post"> Posted: {{ date('d-m-Y', strtotime($post->submit_date)) }}</p>
                    </div>
        </div>
        @endforeach
        @endif

        <div class="new-post">
            <form action="{{ route('create_post', ['project' => $project->id]) }}" method="POST">
                @csrf
                <div class="new-post-body">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Write your post here..."></textarea>
                </div>
                <div class="new-post-footer">
                    <button type="submit">Post</button>
                </div>
            </form>
        </div>
        </div>
    </section>



@endsection
