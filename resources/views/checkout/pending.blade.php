<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Pendiente - Mi Tienda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-md w-full mx-4">
        <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
            ⏳
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pago Pendiente</h1>
        <p class="text-gray-600 mb-6">Estamos esperando la confirmación de tu pago. Si abonaste mediante un medio de pago presencial (como Rapipago o Pago Fácil), la acreditación puede demorar unos minutos u horas.</p>

        <div class="space-y-3">
            <a href="{{ route('home') }}" class="block w-full bg-amber-400 hover:bg-amber-500 text-black font-bold py-2.5 rounded-lg border-2 border-black transition">
                Volver a la Tienda
            </a>
        </div>
    </div>

</body>
</html>
