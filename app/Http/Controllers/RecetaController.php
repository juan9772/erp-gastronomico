<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Receta;
use App\Models\Producto;
use App\Models\Insumo;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::with('insumos')->latest()->paginate(10);
        return view('recetas.index', compact('recetas'));
    }

    public function create()
    {
        return view('recetas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Receta::create($validated);

        return redirect()->route('recetas.index')->with('success', 'Receta creada correctamente.');
    }

    public function show(string $id)
    {
        // Not used right now
    }

    public function edit(Receta $receta)
    {
        $insumos = Insumo::all();
        return view('recetas.edit', compact('receta', 'insumos'));
    }

    public function update(Request $request, Receta $receta)
    {
        // Si viene request de agregar insumo
        if ($request->has('action_attach_insumo')) {
            $request->validate([
                'insumo_id' => 'required|exists:insumos,id',
                'cantidad' => 'required|numeric|min:0.01'
            ]);
            // detach first to avoid duplicate pivot then attach
            $receta->insumos()->detach($request->insumo_id);
            $receta->insumos()->attach($request->insumo_id, ['cantidad' => $request->cantidad]);
            return redirect()->route('recetas.edit', $receta)->with('success', 'Ingrediente añadido a la receta.');
        }

        // Si viene request de remover insumo
        if ($request->has('action_detach_insumo')) {
            $receta->insumos()->detach($request->insumo_id);
            return redirect()->route('recetas.edit', $receta)->with('success', 'Ingrediente removido de la receta.');
        }

        // Actualizar nombre de receta
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $receta->update($validated);

        return redirect()->route('recetas.index')->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        $receta->delete();

        return redirect()->route('recetas.index')->with('success', 'Receta eliminada correctamente.');
    }
}
