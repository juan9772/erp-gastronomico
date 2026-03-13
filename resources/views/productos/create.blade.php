<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-8">
                
                <form method="POST" action="{{ route('productos.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="nombre" value="Nombre del Producto" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="precio_venta" value="Precio de Venta ($)" />
                            <x-text-input id="precio_venta" name="precio_venta" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio_venta', 0)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('precio_venta')" />
                        </div>
                        <div>
                            <x-input-label for="receta_id" value="Receta Asociada (Opcional)" />
                            <select id="receta_id" name="receta_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Ninguna</option>
                                @foreach($recetas as $receta)
                                    <option value="{{ $receta->id }}" @if(old('receta_id') == $receta->id) selected @endif>{{ $receta->nombre }} (Costo: ${{ number_format($receta->costo_total, 2) }})</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('receta_id')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('productos.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                        <x-primary-button class="bg-emerald-600 hover:bg-emerald-700">
                            Guardar Producto
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
