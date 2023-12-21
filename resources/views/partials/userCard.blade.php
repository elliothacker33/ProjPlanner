<section class="userCard {{$size}}">
    <img class="icon avatar" src="{{ $user->image() }}" alt="default user icon">
    <section class="info">
        <h3>{{$user->name}}</h3>
        <h5>{{$user->email}}</h5>
    </section>

</section>