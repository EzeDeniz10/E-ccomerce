<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- Navbar --}}
    @include('components.navbar')

    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar --}}
            @include('components.sidebar')

            {{-- Contenido --}}
            <main class="col-md-10 p-4">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Footer --}}
    @include('components.footer')

</body>
</html>
