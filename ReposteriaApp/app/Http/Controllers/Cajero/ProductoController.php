<?php

namespace App\Http\Controllers\Cajero;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        // Usa vista pensada para catálogo de cajero
        $catalogo = DB::table('vw_cajero_productos_disponibles')
            ->orderBy('pro_nom')
            ->orderBy('tam_nom')
            ->get();

        $productos = $catalogo->groupBy('pro_nom')->map(function ($items) {
            return $items->map(function ($item) {
                return (object) [
                    'pro_nom' => $item->pro_nom,
                    'tam_nom' => $item->tam_nom,
                    'prp_precio' => $item->prp_precio,
                ];
            });
        });

        return view('cajero.productos.index', compact('productos'));
    }
}
