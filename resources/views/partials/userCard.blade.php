<section class="userCard {{$size}}">
    <img class="icon avatar" src="{{\App\Http\Controllers\FileController::get('user',$user->id)?:asset('img/default_user.jpg') }}" alt="default user icon">
    <section class="info">
        <h3>{{$user->name}}</h3>
        <h5>{{$user->email}}</h5>
    </section>

</section>