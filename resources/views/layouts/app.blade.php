<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/about.css') }}" rel="stylesheet">


        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>

        @stack('styles')
        <!-- Scripts -->
        @stack('scripts')

    </head>
    <body>
        <main>
            <header>
                <section>
                    <h1>Project Planer</h1>
                    @if (Auth::check())
                        <a class="user_icon" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
                    @else
                        <a class="user_icon" href="{{ url('/login') }}"> <img class="icon" src="{{ asset('img/default_user.png') }}" alt="default user icon"></a>
                    @endif
                </section>
                @if(View::hasSection('navbar'))
                    <nav>
                        <ul>
                            @yield('navbar')
                        </ul>
                    </nav>
                @endif

            </header>
            <section id="content">
                @yield('content')
            </section>
            <footer>
                <section >
                    <ul>
                        <li><a>FAQ</a></li>
                        <li><a>About Us</a></li>
                        <li><a href="{{ url('/contacts') }}">Contact Us</a></li>
                    </ul>

                </section>
                <section><h6>@2023 Project Planer All rights reserve</h6></section>
            </footer>
        </main>

    </body>
</html>