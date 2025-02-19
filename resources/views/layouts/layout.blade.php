<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Picker-Upper')</title>
    <!-- Font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
        <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/master.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-design.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/question-show.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/mainpage.css') }}" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <header>
        <div class="header_logo-container">
            <a href="{{ route('questions.main') }}">
                <img class="logo" src="{{ asset('assets/img/picker-upper_logo.gif') }}" alt="Logo">
            </a>
        </div>

        <div class="header-menu">
            <button id="menuButton" class="header-menu-button"><i class="fa-regular fa-user"></i></button>
            <div id="menu_list" class="header-links">
                @if (Route::has('login'))
                    @auth
                        <div class="header-links_menu out">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </div>
                    @else
                        <div class="header-links_menu out">
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </header>


    <main>
        <div class="container">
            @yield('content')
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
    <script src="{{ asset('assets/js/header.js') }}"></script>
</body>

</html>
