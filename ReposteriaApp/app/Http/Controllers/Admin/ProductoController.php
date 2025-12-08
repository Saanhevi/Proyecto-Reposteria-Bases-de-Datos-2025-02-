<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetallePedido;
use App\Models\Producto;
use App\Models\ProductoPresentacion;
use App\Models\Receta;
use App\Models\Tamano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('receta')
            ->withCount('presentaciones')
            ->orderBy('pro_nom')
            ->get();

        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recetas = Receta::orderBy('rec_nom')->get();
        $tamanos = Tamano::orderBy('tam_porciones')->get();

        return view('admin.productos.create', compact('recetas', 'tamanos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $presentaciones = collect($request->input('presentaciones', []))
            ->filter(fn ($presentacion) => isset($presentacion['tam_id']));

        $data = [
            'pro_nom' => $request->input('pro_nom'),
            'rec_id' => $request->input('rec_id'),
            'presentaciones' => $presentaciones->toArray(),
        ];

        $validator = Validator::make(
            $data,
            [
                'pro_nom' => 'required|string|max:100',
                'rec_id' => 'required|exists:Receta,rec_id',
                'presentaciones' => 'required|array|min:1',
                'presentaciones.*.tam_id' => 'required|exists:Tamano,tam_id',
                'presentaciones.*.precio' => 'required|numeric|min:0',
            ],
            [],
            [
                'pro_nom' => 'nombre del producto',
                'rec_id' => 'receta base',
                'presentaciones.*.precio' => 'precio',
            ]
        );

        $validator->after(function ($validator) use ($presentaciones) {
            if ($presentaciones->pluck('tam_id')->duplicates()->isNotEmpty()) {
                $validator->errors()->add('presentaciones', 'Cada tamaño solo puede agregarse una vez.');
            }
        });

        $validated = $validator->validate();

        try {
            DB::transaction(function () use ($validated) {
                $productoResult = DB::select('CALL pas_insert_producto(?, ?)', [
                    $validated['pro_nom'],
                    $validated['rec_id'],
                ]);

                $proId = $productoResult[0]->pro_id ?? null;

                if (!$proId) {
                    throw new \RuntimeException('No se pudo obtener el identificador del producto.');
                }

                foreach ($validated['presentaciones'] as $presentacion) {
                    DB::select('CALL pas_insert_producto_presentacion(?, ?, ?)', [
                        $proId,
                        $presentacion['tam_id'],
                        $presentacion['precio'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo crear el producto. Por favor intenta de nuevo.')
                ->withErrors(['store' => $e->getMessage()]);
        }

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presentacion = ProductoPresentacion::with(['producto.receta', 'tamano'])->findOrFail($id);
        $recetas = Receta::orderBy('rec_nom')->get();

        return view('admin.productos.edit', compact('presentacion', 'recetas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $presentacion = ProductoPresentacion::with('producto')->findOrFail($id);

        $request->validate([
            'pro_nom' => 'required|string|max:100',
            'rec_id' => 'required|exists:Receta,rec_id',
            'prp_precio' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $presentacion) {
                DB::statement('CALL pas_update_producto(?, ?, ?)', [
                    $presentacion->pro_id,
                    $request->pro_nom,
                    $request->rec_id,
                ]);

                DB::statement('CALL pas_update_producto_presentacion(?, ?)', [
                    $presentacion->prp_id,
                    $request->prp_precio,
                ]);
            });
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo actualizar la información.')
                ->withErrors(['update' => $e->getMessage()]);
        }

        return redirect()->route('admin.productos.showPresentaciones', $presentacion->pro_id)
            ->with('success', 'Producto y presentación actualizados con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::with('presentaciones')->findOrFail($id);
        $presentacionIds = $producto->presentaciones->pluck('prp_id');

        if (DetallePedido::whereIn('prp_id', $presentacionIds)->exists()) {
            return redirect()->route('admin.productos.index')
                ->with('error', 'Este producto se encuentra en pedidos y no puede ser eliminado.');
        }

        try {
            DB::statement('CALL pas_delete_producto(?)', [$id]);
        } catch (\Throwable $e) {
            return redirect()->route('admin.productos.index')
                ->with('error', 'No se pudo eliminar el producto.')
                ->withErrors(['delete' => $e->getMessage()]);
        }

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado con éxito.');
    }

    /**
     * Remove the specified product presentation from storage.
     */
    public function destroyPresentacion(string $id)
    {
        $presentacion = ProductoPresentacion::findOrFail($id);

        if (DetallePedido::where('prp_id', $presentacion->prp_id)->exists()) {
            return redirect()->route('admin.productos.showPresentaciones', $presentacion->pro_id)
                ->with('error', 'Esta presentación se encuentra en pedidos y no puede ser eliminada.');
        }

        try {
            DB::statement('CALL pas_delete_producto_presentacion(?)', [$presentacion->prp_id]);
        } catch (\Throwable $e) {
            return redirect()->route('admin.productos.showPresentaciones', $presentacion->pro_id)
                ->with('error', 'No se pudo eliminar la presentación.')
                ->withErrors(['delete' => $e->getMessage()]);
        }

        return redirect()->route('admin.productos.showPresentaciones', $presentacion->pro_id)
            ->with('success', 'Presentación eliminada con éxito.');
    }

    /**
     * Display the presentations for a specific product.
     */
    public function showPresentaciones(string $id)
    {
        $producto = Producto::with(['receta', 'presentaciones.tamano'])->findOrFail($id);
        return view('admin.productos.show_presentaciones', compact('producto'));
    }

    /**
     * Show the form for creating a new presentation for a specific product.
     */
    public function createPresentacion(string $pro_id)
    {
        $producto = Producto::with('receta')->findOrFail($pro_id);
        $tamanos = Tamano::orderBy('tam_porciones')->get();
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
                function ($attribute, $value, $fail) use ($pro_id) {
                    if (ProductoPresentacion::where('pro_id', $pro_id)->where('tam_id', $value)->exists()) {
                        $fail('Ya existe una presentación para este producto con el tamaño seleccionado.');
                    }
                },
            ],
            'prp_precio' => 'required|numeric|min:0',
        ]);

        try {
            DB::select('CALL pas_insert_producto_presentacion(?, ?, ?)', [
                $pro_id,
                $request->tam_id,
                $request->prp_precio,
            ]);
        } catch (\Throwable $e) {
            return redirect()->route('admin.productos.showPresentaciones', $pro_id)
                ->with('error', 'No se pudo crear la presentación.')
                ->withErrors(['store' => $e->getMessage()]);
        }

        return redirect()->route('admin.productos.showPresentaciones', $pro_id)
            ->with('success', 'Presentación agregada con éxito.');
    }
}
