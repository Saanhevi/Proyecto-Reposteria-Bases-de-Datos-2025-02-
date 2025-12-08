<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    public function index()
    {
        $compras = DB::table('Compra as c')
            ->join('Proveedor as p', 'c.prov_id', '=', 'p.prov_id')
            ->select(
                'c.com_id',
                'c.com_fec',
                'c.com_tot',
                'p.prov_nom'
            )
            ->groupBy('c.com_id', 'c.com_fec', 'c.com_tot', 'p.prov_nom')
            ->orderByDesc('c.com_fec')
            ->paginate(10); // Paginate with 10 items per page

        return view('admin.compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = DB::table('Proveedor')->orderBy('prov_nom')->get();
        $ingredientes = DB::table('Ingrediente')->orderBy('ing_nom')->get();
        return view('admin.compras.create', compact('proveedores', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prov_id' => 'required|exists:Proveedor,prov_id',
            'com_fec' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.ing_id' => 'required|exists:Ingrediente,ing_id',
            'items.*.dco_can' => 'required|numeric|min:0.01',
            'items.*.dco_pre' => 'required|numeric|min:0',
            // 'confirmar' => 'nullable|boolean', // Removed validation for 'confirmar'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $total = collect($request->items)->reduce(function ($carry, $item) {
                    return $carry + ($item['dco_can'] * $item['dco_pre']);
                }, 0);

                $resultado = DB::select('CALL pas_insert_compra(?, ?, ?)', [
                    $request->prov_id,
                    $request->com_fec,
                    $total,
                ]);

                $comId = $resultado[0]->com_id ?? null;
                if (!$comId) {
                    throw new \RuntimeException('No se pudo obtener el ID de la compra.');
                }

                foreach ($request->items as $item) {
                    DB::select('CALL pas_insert_detalle_compra(?, ?, ?, ?)', [
                        $comId,
                        $item['ing_id'],
                        $item['dco_can'],
                        $item['dco_pre'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Error al registrar compra: '.$e->getMessage());
            return back()->withInput()->with('error', 'No se pudo registrar la compra.');
        }

        return redirect()->route('admin.compras.index')->with('success', 'Compra registrada correctamente.');
    }

    public function edit($id)
    {
        $compra = DB::table('Compra')->where('com_id', $id)->first();
        abort_unless($compra, 404);

        $detalles = DB::table('DetalleCompra as dc')
            ->join('Ingrediente as i', 'dc.ing_id', '=', 'i.ing_id')
            ->where('dc.com_id', $id)
            ->select('dc.ing_id', 'dc.dco_can', 'dc.dco_pre', 'i.ing_nom')
            ->get();

        $proveedores = DB::table('Proveedor')->orderBy('prov_nom')->get();
        $ingredientes = DB::table('Ingrediente')->orderBy('ing_nom')->get();

        return view('admin.compras.edit', compact('compra', 'detalles', 'proveedores', 'ingredientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prov_id' => 'required|exists:Proveedor,prov_id',
            'com_fec' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.ing_id' => 'required|exists:Ingrediente,ing_id',
            'items.*.dco_can' => 'required|numeric|min:0.01',
            'items.*.dco_pre' => 'required|numeric|min:0',
            // 'confirmar' => 'nullable|boolean', // Removed validation for 'confirmar'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $total = collect($request->items)->reduce(function ($carry, $item) {
                    return $carry + ($item['dco_can'] * $item['dco_pre']);
                }, 0);

                DB::table('Compra')
                    ->where('com_id', $id)
                    ->update([
                        'prov_id' => $request->prov_id,
                        'com_fec' => $request->com_fec,
                        'com_tot' => $total,
                    ]);

                // Limpiar e insertar detalle usando PAS (triggers actualizan stock)
                DB::table('DetalleCompra')->where('com_id', $id)->delete();

                foreach ($request->items as $item) {
                    DB::select('CALL pas_insert_detalle_compra(?, ?, ?, ?)', [
                        $id,
                        $item['ing_id'],
                        $item['dco_can'],
                        $item['dco_pre'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Error al actualizar compra: '.$e->getMessage());
            return back()->withInput()->with('error', 'No se pudo actualizar la compra.');
        }

        return redirect()->route('admin.compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function show($id)
    {
        $compra = DB::table('Compra')->where('com_id', $id)->first();
        abort_unless($compra, 404);

        $detalles = DB::table('DetalleCompra as dc')
            ->join('Ingrediente as i', 'dc.ing_id', '=', 'i.ing_id')
            ->where('dc.com_id', $id)
            ->select('dc.ing_id', 'dc.dco_can', 'dc.dco_pre', 'i.ing_nom')
            ->get();
        
        $proveedor = DB::table('Proveedor')->where('prov_id', $compra->prov_id)->first();

        return view('admin.compras.show', compact('compra', 'detalles', 'proveedor'));
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                DB::table('DetalleCompra')->where('com_id', $id)->delete();
                DB::table('Compra')->where('com_id', $id)->delete();
            });
        } catch (\Throwable $e) {
            Log::error('Error al eliminar compra: '.$e->getMessage());
            return redirect()->route('admin.compras.index')->with('error', 'No se pudo eliminar la compra.');
        }

        return redirect()->route('admin.compras.index')->with('success', 'Compra eliminada correctamente y stock actualizado.');
    }
}
