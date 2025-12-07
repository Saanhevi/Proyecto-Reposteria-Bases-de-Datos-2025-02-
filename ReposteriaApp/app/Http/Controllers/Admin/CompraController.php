<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

        DB::transaction(function () use ($request) {
            $total = collect($request->items)->reduce(function ($carry, $item) {
                return $carry + ($item['dco_can'] * $item['dco_pre']);
            }, 0);

            $comId = DB::table('Compra')->insertGetId([
                'prov_id' => $request->prov_id,
                'com_fec' => $request->com_fec,
                'com_tot' => $total,
            ]);

            foreach ($request->items as $item) {
                DB::table('DetalleCompra')->insert([
                    'com_id' => $comId,
                    'ing_id' => $item['ing_id'],
                    'dco_can' => $item['dco_can'],
                    'dco_pre' => $item['dco_pre'],
                ]);
            }

            // Always update stock since checkbox is removed
            $this->actualizarStockCompra($comId);
        });

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

            DB::table('DetalleCompra')->where('com_id', $id)->delete();

            foreach ($request->items as $item) {
                DB::table('DetalleCompra')->insert([
                    'com_id' => $id,
                    'ing_id' => $item['ing_id'],
                    'dco_can' => $item['dco_can'],
                    'dco_pre' => $item['dco_pre'],
                ]);
            }

            // Always update stock since checkbox is removed
            $this->actualizarStockCompra($id);
        });

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
        DB::transaction(function () use ($id) {
            // First, revert the stock for the items in this purchase
            $this->revertirStockCompra($id);

            // Then, delete the purchase details
            DB::table('DetalleCompra')->where('com_id', $id)->delete();

            // Finally, delete the purchase itself
            DB::table('Compra')->where('com_id', $id)->delete();
        });

        return redirect()->route('admin.compras.index')->with('success', 'Compra eliminada correctamente y stock actualizado.');
    }

    private function actualizarStockCompra(int $comId): void
    {
        $detalles = DB::table('DetalleCompra')->where('com_id', $comId)->get();
        foreach ($detalles as $detalle) {
            DB::table('Ingrediente')
                ->where('ing_id', $detalle->ing_id)
                ->update(['ing_stock' => DB::raw('ing_stock + ' . $detalle->dco_can)]);
        }
    }

    private function revertirStockCompra(int $comId): void
    {
        $detalles = DB::table('DetalleCompra')->where('com_id', $comId)->get();
        foreach ($detalles as $detalle) {
            DB::table('Ingrediente')
                ->where('ing_id', $detalle->ing_id)
                ->update(['ing_stock' => DB::raw('ing_stock - ' . $detalle->dco_can)]);
        }
    }
}
