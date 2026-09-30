<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-900 leading-tight">
                {{ __('Tu Carrito de Compras') }}
            </h2>
            <a href="{{ route('home') }}" class="bg-slate-800 text-amber-400 border border-amber-400/30 hover:bg-slate-700 px-4 py-2 rounded-xl text-sm font-bold transition">
                Seguir comprando
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Mensajes de éxito -->
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-xl mb-6 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($cart) && count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Lista de Productos (Columna Izquierda / Ancha) -->
                    <div class="lg:col-span-2 space-y-4">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php
                                $subtotal = $details['price'] * $details['quantity'];
                                $total += $subtotal;
                            @endphp
                            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 flex flex-col sm:flex-row items-center justify-between gap-4">

                                <!-- Foto + Nombre -->
                                <div class="flex items-center space-x-4 w-full sm:w-auto">
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                                        @if(!empty($details['image']))
                                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400 font-bold">Sin foto</div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-base">{{ $details['name'] }}</h3>
                                        <p class="text-gray-500 text-xs font-semibold">Precio unitario: ${{ number_format($details['price'], 2) }}</p>
                                        <p class="text-emerald-600 font-black text-sm mt-1 sm:hidden">Subtotal: ${{ number_format($subtotal, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Controles de Cantidad + Borrar + Subtotal -->
                                <div class="flex items-center justify-between w-full sm:w-auto space-x-6">

                                    <!-- Formulario Actualizar Cantidad -->
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" max="{{ $details['stock'] ?? 99 }}"
                                               class="w-16 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-1.5 text-center font-bold">
                                        <button type="submit" class="bg-gray-200 text-gray-700 hover:bg-slate-800 hover:text-white px-2 py-1 rounded-md text-xs font-bold transition">
                                            ↻
                                        </button>
                                    </form>

                                    <!-- Subtotal en Pantallas Grandes -->
                                    <div class="hidden sm:block text-right">
                                        <span class="text-emerald-600 font-black text-base">${{ number_format($subtotal, 2) }}</span>
                                    </div>

                                    <!-- Formulario Eliminar -->
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1 font-bold text-lg" title="Eliminar del carrito">
                                            ✕
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- Resumen del Pedido (Columna Derecha) -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 h-fit space-y-6">
                        <h2 class="text-xl font-black text-slate-900 border-b pb-3">Resumen de Compra</h2>

                        <div class="space-y-3 text-sm font-medium">
                            <div class="flex justify-between text-gray-600">
                                <span>Productos ({{ count($cart) }})</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Envío</span>
                                <span class="text-emerald-600 font-bold">Gratis</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-lg font-black text-slate-900">
                                <span>Total</span>
                                <span class="text-emerald-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="w-full py-3.5 bg-emerald-500 text-white font-black text-base rounded-xl hover:bg-emerald-600 transition shadow-lg text-center block">
                            PROCEDER AL PAGO
                        </a>
                    </div>

                </div>
            @else
                <!-- Carrito Vacío -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-12 text-center max-w-lg mx-auto">
                    <div class="text-5xl mb-4">🛒</div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Tu carrito está vacío</h2>
                    <p class="text-gray-500 text-sm mb-6">Parece que todavía no agregaste ningún producto a tu carrito.</p>
                    <a href="{{ route('home') }}" class="inline-block py-3 px-6 bg-amber-400 text-slate-900 font-black text-sm rounded-xl hover:bg-amber-500 transition shadow-md">
                        IR A EXPLORAR PRODUCTOS
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
