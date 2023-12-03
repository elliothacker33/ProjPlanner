<section class="multiselector">
@if($data=="users")
    <span><i class="fa-solid fa-users"></i>  Assign users <i class="fas fa-chevron-up "></i></span>
    <section class="dropdown hidden">
        @foreach($users as $user )
            <section class="item">
                <input type="checkbox" name="assign" id="{{$user->id}}" value="{{$user->id}}">
                <label for="{{$user->id}}"> @include('partials.userCard',['size'=>'small'])</label>
            </section>
        @endforeach
    </section>

@elseif(date("tags"))
    <span> <i class="fa-solid fa-tag"></i>  Assign tags <i class="fas fa-chevron-up "></i></span>
    <section class="dropdown hidden">
        @foreach($tags as $tag )
            <section class="item">
                <input type="checkbox" name="tags" id="{{$tag->id}}" value="{{$tag->id}}">
                <label for="{{$tag->id}}"> {{$tag->title}}</label>
            </section>
        @endforeach
    </section>
@endif
</section>