@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/editPost.js') }}" defer></script>
@endpush


@section('content')

    <section class="forum">

        <div class="forum-container">
            
            @if (count($posts) === 0)
                <div id="no-posts">
                    <p>There are no posts yet. Be the first posting here!</p>
                </div>
            @endif
            @foreach ($posts as $post)
                @if (Auth::user()->id == $post->user_id)
                    <div class="own-post" id="{{$post->id}}">
                @else
                    <div class="participants-post">
                @endif
                        <div class="post-header">
                            <div class="post-user">
                                @include('partials.userCard', ['size' => '', 'user' => $post->user])
                            </div>
                            @if (Auth::user()->id === $post->user_id)
                                <div class="post-edit">
                                    <button class="edit-post"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('delete_post', ['project' => $project, 'post' => $post]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-post" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="post-content"> 
                            <div class="post-body">
                                <p class="content">{{ $post->content }}</p>
                            </div>
                            <div class="post-footer">
                                <p class="date-post"> 
                                @if ($post->last_edited !== null) 
                                    Last edited: {{ date('d-m-Y', strtotime($post->last_edited)) }}
                                @else
                                    Posted: {{ date('d-m-Y', strtotime($post->submit_date)) }}
                                @endif
                                </p>
                            </div>
                        </div>
                </div>
            @endforeach

        </div>

        <div class="new-post">
            <form action="{{ route('create_post', ['project' => $project->id]) }}" method="POST">
                @csrf
                <div class="new-post-body">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Write your post here..."></textarea>
                    @if($errors->has('content'))
                        <span class="error">
                            {{ $errors->first('content') }}
                        </span>
                    @endif
                </div>
                <div class="new-post-footer">
                    <button type="submit">Post</button>
                </div>
            </form>
        </div>
        
    </section>

    

@endsection
