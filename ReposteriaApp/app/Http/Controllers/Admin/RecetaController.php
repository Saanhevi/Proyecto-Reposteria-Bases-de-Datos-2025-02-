<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::orderBy('rec_nom')->paginate(10);
        return view('admin.recetas.index', compact('recetas'));
    }

    public function create()
    {
        $ingredientes = DB::table('ingrediente')->get();
        return view('admin.recetas.create', compact('ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rec_nom' => 'required|string|max:100|unique:receta,rec_nom',
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*.id' => 'required|integer|exists:ingrediente,ing_id',
            'ingredientes.*.cantidad' => 'required|numeric|min:0.01',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $recetaResult = DB::select('CALL pas_insert_receta(?)', [$request->rec_nom]);
                $recetaId = $recetaResult[0]->rec_id ?? null;

                if (!$recetaId) {
                    throw new \RuntimeException('No se pudo obtener el ID de la receta.');
                }

                foreach ($request->ingredientes as $ingrediente) {
                    DB::statement('CALL pas_insert_detalle_receta(?, ?, ?)', [
                        $recetaId,
                        $ingrediente['id'],
                        $ingrediente['cantidad'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No se pudo crear la receta.')
                ->withErrors(['store' => $e->getMessage()]);
        }

        return redirect()->route('admin.recetas.index')->with('success', 'Receta creada con éxito.');
    }

    public function show(Receta $receta)
    {
        $detalles = DB::table('detallereceta as dr')
            ->join('ingrediente as i', 'dr.ing_id', '=', 'i.ing_id')
            ->where('dr.rec_id', $receta->rec_id)
            ->select('i.ing_nom', 'dr.dre_can', 'i.ing_um')
            ->get();

        return view('admin.recetas.show', compact('receta', 'detalles'));
    }

    public function edit(Receta $receta)
    {
        $ingredientes = DB::table('ingrediente')->get();
        $detalles = DB::table('detallereceta as dr')
            ->join('ingrediente as i', 'dr.ing_id', '=', 'i.ing_id')
            ->where('dr.rec_id', $receta->rec_id)
            ->select('i.ing_id', 'i.ing_nom', 'dr.dre_can', 'i.ing_um')
            ->get();

        $recipeIngredients = $detalles->map(function ($detalle) {
            return [
                'id' => (string) $detalle->ing_id,
                'name' => htmlspecialchars($detalle->ing_nom, ENT_QUOTES, 'UTF-8'),
                'quantity' => (float) $detalle->dre_can,
                'um' => htmlspecialchars($detalle->ing_um, ENT_QUOTES, 'UTF-8'),
            ];
        })->toArray();

        return view('admin.recetas.edit', compact('receta', 'ingredientes', 'recipeIngredients'));
    }

    public function update(Request $request, Receta $receta)
    {
        $request->validate([
            'rec_nom' => ['required', 'string', 'max:100', Rule::unique('receta')->ignore($receta->rec_id, 'rec_id')],
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*.id' => 'required|integer|exists:ingrediente,ing_id',
            'ingredientes.*.cantidad' => 'required|numeric|min:0.01',
        ]);

        try {
            DB::transaction(function () use ($request, $receta) {
                DB::statement('CALL pas_update_receta(?, ?)', [$receta->rec_id, $request->rec_nom]);

                $nuevosIngredientes = collect($request->ingredientes);
                $nuevosIds = $nuevosIngredientes->pluck('id')->map(fn ($id) => (int) $id);

                foreach ($nuevosIngredientes as $ingrediente) {
                    DB::statement('CALL pas_insert_detalle_receta(?, ?, ?)', [
                        $receta->rec_id,
                        $ingrediente['id'],
                        $ingrediente['cantidad'],
                    ]);
                }

                $ingredientesActuales = DB::table('DetalleReceta')
                    ->where('rec_id', $receta->rec_id)
                    ->pluck('ing_id');

                $paraEliminar = $ingredientesActuales->diff($nuevosIds);

                foreach ($paraEliminar as $ingId) {
                    DB::statement('CALL pas_delete_detalle_receta(?, ?)', [$receta->rec_id, $ingId]);
                }
            });
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No se pudo actualizar la receta.')
                ->withErrors(['update' => $e->getMessage()]);
        }

        return redirect()->route('admin.recetas.index')->with('success', 'Receta actualizada con éxito.');
    }

    public function destroy(Receta $receta)
    {
        if (Producto::where('rec_id', $receta->rec_id)->exists()) {
            return redirect()->route('admin.recetas.index')->with('error', 'No se puede eliminar la receta porque está asociada a un producto.');
        }

        try {
            DB::statement('CALL pas_delete_receta(?)', [$receta->rec_id]);
        } catch (\Throwable $e) {
            return redirect()->route('admin.recetas.index')
                ->with('error', 'No se pudo eliminar la receta.')
                ->withErrors(['delete' => $e->getMessage()]);
        }

        return redirect()->route('admin.recetas.index')->with('success', 'Receta eliminada con éxito.');
    }
}
