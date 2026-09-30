<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Producto:') }} {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Muestra errores de validación si los hay --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Categoría --}}
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría *</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nombre del Producto --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Producto *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white" required>
                    </div>

                    {{-- Proveedor --}}
                    <div class="mb-4">
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proveedor (Opcional)</label>
                        <select name="supplier_id" id="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">-- Sin Proveedor / Producto Propio --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ (old('supplier_id', $product->supplier_id) == $supplier->id) ? 'selected' : '' }}>
                                    {{ $supplier->name }} ({{ ucfirst($supplier->type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Precio y Stock --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio ($) *</label>
                            <!-- OPTIMIZADO: inputmode="decimal" para móviles -->
                            <input type="number" step="0.01" min="0" inputmode="decimal" name="price" id="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white" required>
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Disponible *</label>
                            <!-- OPTIMIZADO: inputmode="numeric" para móviles -->
                            <input type="number" min="0" inputmode="numeric" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white" required>
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Imagen --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Imagen Actual</label>
                        @if($product->image)
                            <!-- OPTIMIZADO: atributo onerror agregado -->
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';"
                                 alt="{{ $product->name }}"
                                 class="w-32 h-32 object-cover rounded-lg mb-3 border">
                        @else
                            <p class="text-sm text-gray-500 mb-3 italic">Sin imagen asignada.</p>
                        @endif
                        <!-- OPTIMIZADO: accept="image/*" agregado -->
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-500 text-white font-medium text-sm rounded-lg hover:bg-gray-600 transition shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-amber-400 text-black font-extrabold text-sm rounded-lg border-2 border-black hover:bg-amber-500 block shadow-md transition">
                            ACTUALIZAR PRODUCTO
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
