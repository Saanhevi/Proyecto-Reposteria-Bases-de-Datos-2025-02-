<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductoPresentacion;
use App\Models\Receta;
use App\Models\Tamano;
use App\Models\DetallePedido; // Add this line
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // User requested to implement this later
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // User requested to implement this later
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presentacion = ProductoPresentacion::with(['producto', 'tamano'])->findOrFail($id);
        $productos = Producto::all(); // For selecting product
        $tamanos = Tamano::all(); // For selecting tamano
        return view('admin.productos.edit', compact('presentacion', 'productos', 'tamanos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $presentacion = ProductoPresentacion::findOrFail($id);

        $request->validate([
            'pro_id' => 'required|exists:Producto,pro_id',
            'tam_id' => 'required|exists:Tamano,tam_id',
            'prp_precio' => 'required|numeric|min:0',
            'pro_nom' => 'required|string|max:100', // Assuming product name can be updated here
        ]);

        // Update Producto name
        $producto = Producto::findOrFail($request->pro_id);
        $producto->update(['pro_nom' => $request->pro_nom]);

        // Update ProductoPresentacion
        $presentacion->update([
            'pro_id' => $request->pro_id,
            'tam_id' => $request->tam_id,
            'prp_precio' => $request->prp_precio,
        ]);

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::with('presentaciones')->findOrFail($id);

        // Check if any of the product's presentations are in DetallePedido
        foreach ($producto->presentaciones as $presentacion) {
            if (\App\Models\DetallePedido::where('prp_id', $presentacion->prp_id)->exists()) {
                return redirect()->route('admin.productos.index')
                                 ->with('error', 'Este producto se encuentra en pedidos y no puede ser eliminado.');
            }
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto eliminado con éxito');
    }

    /**
     * Remove the specified product presentation from storage.
     */
    public function destroyPresentacion(string $id)
    {
        $presentacion = ProductoPresentacion::findOrFail($id);

        // Check if the presentation is in DetallePedido
        if (\App\Models\DetallePedido::where('prp_id', $presentacion->prp_id)->exists()) {
            return redirect()->route('admin.productos.showPresentaciones', $presentacion->pro_id)
                             ->with('error', 'Esta presentación se encuentra en pedidos y no puede ser eliminada.');
        }

        $presentacion->delete();

        return redirect()->route('admin.productos.showPresentaciones', $presentacion->pro_id)
                         ->with('success', 'Presentación eliminada con éxito');
    }

    /**
     * Display the presentations for a specific product.
     */
    public function showPresentaciones(string $id)
    {
        $producto = Producto::with('presentaciones.tamano')->findOrFail($id);
        return view('admin.productos.show_presentaciones', compact('producto'));
    }

    /**
     * Show the form for creating a new presentation for a specific product.
     */
    public function createPresentacion(string $pro_id)
    {
        $producto = Producto::findOrFail($pro_id);
        $tamanos = Tamano::all();
        return view('admin.productos.create_presentacion', compact('producto', 'tamanos'));
    }

    /**
     * Store a newly created presentation for a specific product.
     */
    public function storePresentacion(Request $request, string $pro_id)
    {
        $request->validate([
            'tam_id' => [
                'required',
                'exists:Tamano,tam_id',
                // Custom rule to prevent duplicate presentations for the same product and size
                function ($attribute, $value, $fail) use ($pro_id) {
                    if (ProductoPresentacion::where('pro_id', $pro_id)->where('tam_id', $value)->exists()) {
                        $fail('Ya existe una presentación para este producto con el tamaño seleccionado.');
                    }
                },
            ],
            'prp_precio' => 'required|numeric|min:0',
        ]);

        ProductoPresentacion::create([
            'pro_id' => $pro_id,
            'tam_id' => $request->tam_id,
            'prp_precio' => $request->prp_precio,
        ]);

        return redirect()->route('admin.productos.showPresentaciones', $pro_id)
                         ->with('success', 'Presentación agregada con éxito');
    }
}
