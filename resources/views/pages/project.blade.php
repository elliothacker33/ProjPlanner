@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush
@section('content')
<section class="projectPage">
    <header>
        <h1 class="title">Dummy project title</h1>
        @if($project->is_archived) <span class="status archive"> Archive </span>
        @else <span class="status open"> Open </span>
        @endif
        @can('edit',$project)
            <select class="status">

            </select>
        @endcan
    </header>
    <section class="container">
    <section class="primaryContainer">

        <section class="description">
            <p>dvbfkjdbfjnhbgdfjgb dfj bgkdjfbgkdbg
            fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
            fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdfdvbfkjdbf jnhbgdfjgb dfj bgkdjfbgkdbg
            fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
            fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdfdvbf kjdbfjnhbgdfjgb dfj bgkdjfbgkdbg
            fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
            fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdf</p>
            <p>dvbfkjdbfjnhbgdfjgb dfj bgkdjfbgkdbg
                fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
                fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdfdvbfkjdbf jnhbgdfjgb dfj bgkdjfbgkdbg
                fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
                fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdfdvbf kjdbfjnhbgdfjgb dfj bgkdjfbgkdbg
                fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
                fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdf</p>
            <p>dvbfkjdbfjnhbgdfjgb dfj bgkdjfbgkdbg
                fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
                fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdfdvbfkjdbf jnhbgdfjgb dfj bgkdjfbgkdbg
                fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
                fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdfdvbf kjdbfjnhbgdfjgb dfj bgkdjfbgkdbg
                fshd fjhsdjf hskjdhfksdhfksdhf kjshdfjksd
                fsjhdfkshdfkjs hdkfhskdjh fkjsdhfjkshdf</p>
        </section>

    </section>
    <section class="sideContainer">
        <section class="completionContainer">
            <span class="completion">Completed Tasks 20/37</span>
        </section>
        <section class="deadlineContainer" >
            <span>DeadLine: 20/9/2021</span>
        </section>
        <section class="teamContainer">
            <h5>Team: </h5>
            <ul class="team">
                <li>DanielDos Santos</li>
                <li>Francisco Cardoso</li>
                <li>ZeAntonioM</li>
                <li>Tomas Pereira</li>
            </ul>
            <a>See all</a>
        </section>
    </section>
    </section>
</section>
@endsection