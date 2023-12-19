@extends('layouts.project')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project/tags.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ asset('js/pages/tags.js') }}" defer></script>
    <script type="module" src="{{ asset('js/modal.js') }}" defer></script>
@endpush

@section('content')
  {{$tags}}
@endsection
