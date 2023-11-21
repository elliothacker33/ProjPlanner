@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/static/faq.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/faq.js') }}" defer></script>
@endpush

@section('content')



<section>

        <div>
            <h1> Some of the most frequently <br> asked questions</h1>
        </div>
        <div class="faq">
            <div class="question" id ="q1">
                <span>What are the main features?</span>
                <button>+</button>
            </div>
            <div class="answer" id="a1">
                <p>Only authorized users can create tasks.</p>
            </div>
            <div class="question" id="q2">
                <span>What is a tag for a project?</span>
                <button>+</button>
            </div>
            <div class="answer" id="a2">
                <p>Only authorized users can create tasks.</p>
            </div>
            <div class="question" id="q3" >
                <span>Can i chat with other participants?</span>
                <button>+</button>
            </div>
            <div class="answer" id="a3">
                <p>Only authorized users can create tasks.</p>
            </div>
            <div class="question" id="q4">
                <span>How to create a task?</span>
                <button>+</button>
            </div>
            <div class="answer" id="a4">
                <p>Only authorized users can create tasks.</p>
            </div>
            <div class="question" id="q5">
                <span>How to create a task?</span>
                <button>+</button>
            </div>
            <div class="answer" id="a5">
                <p>Only authorized users can create tasks.</p>
            </div>
            <div class="question" id="q6">
                <span>How to create a task?</span>
                <button>+</button>
            </div>
            <div class="answer" id="a6">
                <p>Only authorized users can create tasks.</p>
            </div>
            
</div>
</section>
               
</section>

@endsection