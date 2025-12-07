<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RecetaController extends Controller
{
    public function index()
    {
        // Obtener todas las recetas con paginación
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

        DB::transaction(function () use ($request) {
            // Crear la receta
            $receta = Receta::create(['rec_nom' => $request->rec_nom]);

            // Añadir los detalles de la receta
            foreach ($request->ingredientes as $ingrediente) {
                DB::table('detallereceta')->insert([
                    'rec_id' => $receta->rec_id,
                    'ing_id' => $ingrediente['id'],
                    'dre_can' => $ingrediente['cantidad'],
                ]);
            }
        });

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

        $recipeIngredients = $detalles->map(function($detalle) {
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

        DB::transaction(function () use ($request, $receta) {
            // Actualizar el nombre de la receta
            $receta->update(['rec_nom' => $request->rec_nom]);

            // Eliminar los detalles antiguos
            DB::table('detallereceta')->where('rec_id', $receta->rec_id)->delete();

            // Añadir los nuevos detalles
            foreach ($request->ingredientes as $ingrediente) {
                DB::table('detallereceta')->insert([
                    'rec_id' => $receta->rec_id,
                    'ing_id' => $ingrediente['id'],
                    'dre_can' => $ingrediente['cantidad'],
                ]);
            }
        });

        return redirect()->route('admin.recetas.index')->with('success', 'Receta actualizada con éxito.');
    }

    public function destroy(Receta $receta)
    {
        // Validar si la receta está siendo usada por un producto
        $isUsed = DB::table('producto')->where('rec_id', $receta->rec_id)->exists();
        if ($isUsed) {
            return redirect()->route('admin.recetas.index')->with('error', 'No se puede eliminar la receta porque está asociada a un producto.');
        }

        DB::transaction(function () use ($receta) {
            // Eliminar detalles de la receta
            DB::table('detallereceta')->where('rec_id', $receta->rec_id)->delete();
            // Eliminar la receta
            $receta->delete();
        });

        return redirect()->route('admin.recetas.index')->with('success', 'Receta eliminada con éxito.');
    }
}
