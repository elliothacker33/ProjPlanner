<section class="multiselector">
    <span>Assign users &#8964</span>
    <section class="dropdown ">
        @foreach($users as $user )
            <section class="item">
                <input type="checkbox" name="assign" id="{{$user->id}}">
                <label for="{{$user->id}}"> @include('partials.userCard',['size'=>'small'])</label>
            </section>
        @endforeach
    </section>

</section>
