<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href={{url('images/shareef_tube_icon.png')}}>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/home_page.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src= {{ url("/js/app.js") }} ></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img id="main_logo_small" src={{ url("images/Shareef_Tube_Logo_200.png") }}>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    @if (!Auth::guest())
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Videos
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/movies" >
                                            Movies
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/series" >
                                            Series
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/artists" >
                                            Clips
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/genres" >
                                            Genres
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Clients
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <li>
                                    <a href="/activeclients" >
                                        Active
                                    </a>
                                </li>
                                <li>
                                    <a href="/clients" >
                                        Non-Active
                                    </a>
                                </li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="mainwide">
            @yield('clips')
            
            @yield('movies')
                
            @yield('episodes')            
            
            @yield('series')

            @yield('weclome')

            @yield('modal')
            
            @yield('clients')

            <div id='content'>
                @yield('content')
                @yield('movie_list')
                @yield('episodesdetails')
                @yield('movie_detail')
                @yield('series_list')
                @yield('clip_list')    
                @yield('genres')
            </div>
        </div>

    </div>

</body>
</html>
