@extends('layouts.app')

@push('styles')

@endpush

@section('content')

    <section class="appeals">
        @foreach($appeals as $appeal)
            
            <div class="appeal-box">

                <div class="appeal-user">
                    <a href="{{route('profile',['user'=>$appeal->user])}}">
                        @include('partials.userCard',['user'=>$appeal->user, 'size'=>'.small'])
                    </a>               
                </div>

                <div class="appeal-content">
                    <p>{{$appeal->content}}</p>
                </div>

                <div class="appeal-footer">
                    <div class="appeal-buttons">
                        <form method="POST" class="hidden" id="delete-{{$appeal->id}}"
                              action="{{route("delete_appeal",["appeal"=>$appeal])}}">
                            @csrf
                            @method("DELETE")
                        </form>
                        <button class="delete" onclick="event.preventDefault();
                            document.getElementById('delete-{{$appeal->id}}').submit();">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>

                    
                </div>

            </div>

        @endforeach
    </section>
    @include('partials.pagination',['paginator'=>$appeals])



@endsection

