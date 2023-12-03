@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endpush
<section class="userCard {{$size}}" >
    <img class="icon avatar" src="{{ asset('img/default_user.png') }}" alt="default user icon">
    <section class="info">
        <h3>{{$user->name}}</h3>
        <h5>{{$user->email}}</h5>
    </section>
</section>