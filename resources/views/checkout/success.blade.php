<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Compra Exitosa! - Mi Tienda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 antialiased min-h-screen flex flex-col justify-between">

    <main class="max-w-2xl mx-auto px-4 py-16 text-center">
        <div class="bg-white rounded-3xl shadow-xl border p-8 md:p-12 space-y-6">
            <div class="text-6xl text-emerald-500 animate-bounce">🎉</div>
            <h1 class="text-3xl font-black text-slate-900">¡Muchas gracias por tu compra!</h1>
            <p class="text-gray-600 font-medium">Tu pedido se ha registrado correctamente con el número de orden <span class="font-bold text-slate-800">#{{ $order->id }}</span>.</p>

            <div class="border-t border-b border-gray-100 py-4 my-6 text-left space-y-2 text-sm text-gray-700">
                <h3 class="font-bold text-slate-900 uppercase tracking-wider text-xs mb-2">Resumen de Entrega:</h3>
                <p><span class="font-bold">Cliente:</span> {{ $order->customer_name }}</p>
                <p><span class="font-bold">Teléfono:</span> {{ $order->customer_phone }}</p>
                <p><span class="font-bold">Destino:</span> {{ $order->address }}, {{ $order->city }}</p>
                <p class="pt-2 border-t font-black text-lg text-emerald-600">Total abonado: ${{ number_format($order->total_amount, 2) }}</p>
            </div>

            <a href="{{ route('home') }}" class="inline-block w-full py-3.5 bg-amber-400 text-black font-black rounded-xl border-2 border-black hover:bg-amber-500 transition shadow-md">
                VOLVER A LA TIENDA
            </a>
        </div>
    </main>

</body>
</html>

