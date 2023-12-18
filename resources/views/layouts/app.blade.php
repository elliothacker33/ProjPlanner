<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ProjPlanner') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Styles -->
    <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>

    @stack('styles')
    <!-- Scripts -->
    @stack('scripts')

</head>
<body>
    <header>
        <section>
            @if (Auth::check())
                <h1 id="header_title"><a href="{{ route('home', ['usrId' => Auth::id()]) }}" >ProjPlanner</a></h1>
            @else
                <h1 id="header_title"><a href="{{ route('landing') }}">ProjPlanner</a></h1>
            @endif

            @if (Auth::check())

                <a class="user_icon" href="{{ route('profile', ['usrId' => Auth::id()]) }}"> 
                    <img class="icon avatar" src="{{ auth()->user()->getProfileImage() }}" alt="default user icon">
                </a>
                <a id="logout" href="{{ route('logout') }}">Logout</a>
            @else
                <a class="user_icon" href="{{ route('login') }}"> <img class="icon avatar"
                        src="{{ asset('img/user/default_user.jpg') }}" alt="default user icon"></a>
            @endif
        </section>
        @if (View::hasSection('navbar'))
            <nav>
                <ul>
                    @yield('navbar')
                </ul>
            </nav>
        @endif

    </header>
    <main>

        <section id="content">
            @yield('content')
        </section>

        </main>
        <footer>
            <section>
                <ul>


                    <li><a href="{{ route('static',['page' => 'faq'])}}">FAQ</a></li>
                    <li><a href="{{ route('static',['page' => 'about-us'])}}">About Us</a></li>
                    <li><a href="{{ route('static',['page' => 'contacts'])}}">Contact Us</a></li>

                </ul>
            </section>
            <section><h6>&copy;2023 ProjPlanner All Rights Reserved</h6></section>
        </footer>
    </body>
</html>
