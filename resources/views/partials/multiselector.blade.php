<section class="multiselector">
    <span>Assign users <i class="fas fa-chevron-up "></i></span>
    <section class="dropdown hidden">
        @foreach($users as $user )
            <section class="item">
                <input type="checkbox" name="assign" id="{{$user->id}}" value="{{$user->id}}">
                <label for="{{$user->id}}"> @include('partials.userCard',['size'=>'small'])</label>
            </section>
        @endforeach
    </section>

</section>
