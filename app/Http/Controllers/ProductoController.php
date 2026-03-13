<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('receta')->latest()->paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $recetas = \App\Models\Receta::all();
        return view('productos.create', compact('recetas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'receta_id' => 'nullable|exists:recetas,id',
        ]);

        Producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function show(string $id)
    {
        // Not used right now
    }

    public function edit(Producto $producto)
    {
        $recetas = \App\Models\Receta::all();
        return view('productos.edit', compact('producto', 'recetas'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'receta_id' => 'nullable|exists:recetas,id',
        ]);

        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
