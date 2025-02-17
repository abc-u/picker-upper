<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Default Title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <!-- External CSS -->
    @vite('resources/css/show.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <header>
        <img class="logo" src="{{ asset('assets/img/picker-upper_logo.gif') }}" alt="Logo">

        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        </div>
    </header>

    <main class="container">
        @yield('content')
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
</body>

</html>
