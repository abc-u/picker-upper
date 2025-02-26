<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Picker-Upper')</title>
    <!-- Font-awesome -->
    <link rel="icon" href="{{ asset('assets/img/picker-upper_logo.gif') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/master.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-design.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/question-show.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/mainpage.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/login-register.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/map.css') }}" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <header>
        <div class="header_logo-container">
            <a href="{{ route('questions.main') }}">
                <img class="logo" src="{{ asset('assets/img/picker-upper_logo.gif') }}" alt="Logo">
            </a>
        </div>

        @auth
            <div class="header-menu">
                <button id="menuButton" class="header-menu-button">
                    @if (auth()->user()->user_icon)
                        <img src="{{ asset(auth()->user()->user_icon) }}" alt="ユーザー画像"
                            class="rounded-circle img-thumbnail shadow-sm">
                    @else
                        <i class="fa-regular fa-user"></i>
                    @endif
                </button>
                <div id="menu_list" class="header-links">
                    @if (Route::has('login'))
                        <div class="header-links_menu out">
                            <a class="header-links_menuList" href="{{ route('questions.main') }}">Dashboard</a>
                            <a class="header-links_menuList" href="{{ route('map.index') }}">MAP</a>
                            <a class="header-links_menuList" href="{{ route('profile.index') }}">Profile</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="header-links_menuList">Logout</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="non-loginUser-menu">
                <a class="header-links_menuList" href="{{ route('login') }}">Login</a>
                <a class="header-links_menuList" href="{{ route('register') }}">Register</a>
            </div>
        @endauth
    </header>


    <main>
        <div class="main-container">
            <div class="main-itemA">
                @yield('left-content')
            </div>
            <div class="main-itemB">
                @yield('content')
            </div>
            <div class="main-itemC right">
                @yield('right-content')
            </div>
        </div>
    </main>

    <footer>Copyright &copy; MORI YUGO.</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" crossorigin="anonymous">
    </script>

    <!-- External JavaScript -->
    <script src="js/script.js"></script>
    <script src="js/map.js"></script>

    <!-- Google Maps API -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
    <script src="{{ asset('assets/js/header.js') }}"></script>
</body>

</html>
