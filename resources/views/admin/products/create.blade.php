<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Categoría --}}
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría *</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Seleccioná una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nombre del Producto --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Producto *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    {{-- Proveedor --}}
                    <div class="mb-4">
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proveedor (Opcional)</label>
                        <select name="supplier_id" id="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">-- Sin Proveedor / Producto Propio --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }} ({{ ucfirst($supplier->type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Precio y Stock en 2 columnas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio ($) *</label>
                            <!-- CORREGIDO: Se añadieron estilos completas, id, value u old() -->
                            <input type="number" name="price" id="price" step="0.01" min="0" inputmode="decimal" value="{{ old('price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" placeholder="0.00" required>
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Disponible *</label>
                            <!-- CORREGIDO: Se añadió inputmode="numeric" -->
                            <input type="number" name="stock" id="stock" min="0" inputmode="numeric" value="{{ old('stock', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                    </div>

                    {{-- Imagen --}}
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen del Producto</label>
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-500 text-white font-medium text-sm rounded-lg hover:bg-gray-600 transition shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-amber-400 text-black font-extrabold text-sm rounded-lg border-2 border-black hover:bg-amber-500 shadow-md transition">
                            GUARDAR PRODUCTO
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
