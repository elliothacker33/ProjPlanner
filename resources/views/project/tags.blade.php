@php use App\Models\Project; @endphp
@extends('layouts.project')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tags.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">

@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/pages/tags.js') }}" defer></script>
@endpush

@section('content')
    <section class="tagsPage">


        <section class="tags-list">
            <header>
                <section class="search">
                    <input type="search" placeholder="&#128269 Search" aria-label="Search" id="search-bar"/>

                </section>
                <section>
                    <span> <i class="fa-solid fa-tags"></i>  {{count($tags)}} Tags </span>
                    @can('update',[Project::class,$project])
                        <section class="addTagContainer">
                            <form method="POST" action="{{ route('add_tag', ['project' => $project])  }}">
                                {{ csrf_field() }}
                                <input type="text" name="title" placeholder="New Tag Title" required
                                       value="{{old('title')}}">

                                <button type="submit"><i class="fa-solid fa-plus"></i> Add Tag</button>
                            </form>
                            @if ($errors->has('title'))
                                <span class="error">
                            {{ $errors->first('title') }}
                        </span>
                            @endif
                        </section>
                    @endcan
                </section>
            </header>
            <section class="tags">
                @foreach($tags as $tag)
                    <section class="tagSection">
                        @include('partials.tagCard',['tag'=>$tag])
                        <form class="hidden" id="edit-{{$tag->id}}" autocomplete="off">
                            <input required maxlength="20" minlength="1" type="text" name="title" value="{{$tag->title}}">
                            <input type="submit">
                            <span class="error"></span>
                        </form>
                    </section>
                @endforeach
            </section>
        </section>


    </section>
@endsection