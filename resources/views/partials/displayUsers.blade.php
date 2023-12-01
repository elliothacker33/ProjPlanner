
@foreach($users as $user)
    <div class="user">
        <section class="name"> {!! $user->name !!} </section>
        <section class="email"> {!! $user->email !!} </section>
        @if($user->is_admin)
            <section class="role"> Admin </section>
        @else
            <section class="role"> User </section>
        @endif
        <section class="change"> <a href="/user-profile/{!! $user->id !!}/edit"><button> Edit </button></a> </section>
        <section class="change"> <a href="/admin/users/{!! $user->id !!}/delete"><button> Delete </button></a>  </section>
    </div>
@endforeach