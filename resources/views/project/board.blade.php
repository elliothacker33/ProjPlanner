@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project/board.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/cards.css') }}">
@endpush

@push('scripts')
@endpush

@section('content')
    <section class="projectBoard">
        <section class="board">
            <ul>
                <li>
                    <section class="container">
                        <header><h4><i class="fa-solid fa-folder-open"></i> Open <span class="quantity">{{count($open)}}</span></h4></header>
                        <ul>
                            @foreach($open as $task)
                                <li>@include('partials.smallTaskCard',['$project'=>$project,'task'=>$task])</li>
                            @endforeach
                        </ul>
                    </section>
                </li>
                <li>
                    <section class="container">
                        <header><h4><i class="fa-solid fa-folder-closed"></i> Closed <span class="quantity">{{count($closed)}}</span></h4></header>
                        <ul>
                            @foreach($closed as $task)
                                <li>@include('partials.smallTaskCard',['project'=>$project,'task'=>$task])</li>
                            @endforeach
                        </ul>
                    </section>
                </li>
                <li>
                    <section class="container">
                        <header><h4><i class="fa-solid fa-ban"></i> Canceled <span class="quantity">{{count($canceled)}}</span></h4></header>
                        <ul>
                            @foreach($canceled as $task)
                                <li>@include('partials.smallTaskCard',['project'=>$project,'task'=>$task])</li>
                            @endforeach
                        </ul>
                    </section>
                </li>
            </ul>
        </section>
    </section>
@endsection
