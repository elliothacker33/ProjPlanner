@extends('layouts.app')

@push('scripts')
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
@endpush

@section('navbar')
    <li><a>Project Home</a></li>
    <li><a>Team</a></li>
    <li><a>Tasks</a></li>

@endsection

