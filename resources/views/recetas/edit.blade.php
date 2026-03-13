<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Receta') }}: {{ $receta->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Datos de la Receta -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información Principal</h3>
                <form method="POST" action="{{ route('recetas.update', $receta) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nombre" value="Nombre de la Receta" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $receta->nombre)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                            Actualizar Nombre
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Lista de Ingredientes actuales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ingredientes de la Receta</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insumo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Costo Parcial</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($receta->insumos as $insumo)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $insumo->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $insumo->pivot->cantidad }} {{ $insumo->unidad_medida }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ${{ number_format($insumo->pivot->cantidad * $insumo->costo_unitario, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('recetas.update', $receta) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action_detach_insumo" value="1">
                                                <input type="hidden" name="insumo_id" value="{{ $insumo->id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Remover este ingrediente?')">Remover</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">La receta no tiene ingredientes aún.</td>
                                    </tr>
                                @endforelse
                                <tr class="bg-gray-50">
                                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">Costo Total Receta:</td>
                                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">${{ number_format($receta->costo_total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Añadir Nuevo Ingrediente -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Añadir Ingrediente</h3>
                <form method="POST" action="{{ route('recetas.update', $receta) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action_attach_insumo" value="1">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="insumo_id" value="Insumo (Ingrediente)" />
                            <select id="insumo_id" name="insumo_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Seleccione un insumo...</option>
                                @foreach($insumos as $insumo)
                                    <option value="{{ $insumo->id }}">{{ $insumo->nombre }} (Costo: ${{ number_format($insumo->costo_unitario, 2) }} por {{ $insumo->unidad_medida }})</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('insumo_id')" />
                        </div>
                        <div>
                            <x-input-label for="cantidad" value="Cantidad Necesaria" />
                            <x-text-input id="cantidad" name="cantidad" type="number" step="0.01" class="mt-1 block w-full" :value="old('cantidad')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('cantidad')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="bg-emerald-600 hover:bg-emerald-700">
                            Añadir a la Receta
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
