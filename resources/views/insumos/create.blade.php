<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Insumo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-8">
                
                <form method="POST" action="{{ route('insumos.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="nombre" value="Nombre" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="costo_unitario" value="Costo Unitario ($)" />
                            <x-text-input id="costo_unitario" name="costo_unitario" type="number" step="0.01" class="mt-1 block w-full" :value="old('costo_unitario')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('costo_unitario')" />
                        </div>
                        <div>
                            <x-input-label for="unidad_medida" value="Unidad de Medida" />
                            <select id="unidad_medida" name="unidad_medida" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="kg" @if(old('unidad_medida') == 'kg') selected @endif>Kilogramos (kg)</option>
                                <option value="g" @if(old('unidad_medida') == 'g') selected @endif>Gramos (g)</option>
                                <option value="l" @if(old('unidad_medida') == 'l') selected @endif>Litros (l)</option>
                                <option value="ml" @if(old('unidad_medida') == 'ml') selected @endif>Mililitros (ml)</option>
                                <option value="unidad" @if(old('unidad_medida') == 'unidad') selected @endif>Unidad</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('unidad_medida')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('insumos.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            Guardar Insumo
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
