<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Insumo;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::latest()->paginate(10);
        return view('insumos.index', compact('insumos'));
    }

    public function create()
    {
        return view('insumos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'costo_unitario' => 'required|numeric|min:0',
            'unidad_medida' => 'required|string|max:50',
        ]);

        Insumo::create($validated);

        return redirect()->route('insumos.index')->with('success', 'Insumo creado correctamente.');
    }

    public function show(string $id)
    {
        // Not used right now
    }

    public function edit(Insumo $insumo)
    {
        return view('insumos.edit', compact('insumo'));
    }

    public function update(Request $request, Insumo $insumo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'costo_unitario' => 'required|numeric|min:0',
            'unidad_medida' => 'required|string|max:50',
        ]);

        $insumo->update($validated);

        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy(Insumo $insumo)
    {
        $insumo->delete();

        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado correctamente.');
    }
}
