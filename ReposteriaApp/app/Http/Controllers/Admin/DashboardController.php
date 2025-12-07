<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $ventasHoy = DB::select('SELECT fn_admin_num_ped_entregados() as result')[0]->result;

        $pedidosActivos = DB::select('SELECT fn_admin_num_ped_activos() as result')[0]->result;

        $totalProductos = DB::select('SELECT fn_admin_num_productos() as result')[0]->result;

        $productosBajoStock = DB::table('Ingrediente')
            ->whereColumn('ing_stock', '<=', 'ing_reord')
            ->count();

        $empleados = DB::select('SELECT fn_admin_num_empleados() as result')[0]->result;
        $cajeros = DB::table('Cajero')->count();
        $reposteros = DB::table('Repostero')->count();

        $ventasPorMes = DB::table('vw_admin_ventas_por_mes')->get();

        $productosMasVendidos = DB::table('vw_admin_top_productos')->get();

        $searchTerm = $request->input('search_ingredient');

        if ($searchTerm) {
            $estadoInventario = DB::select('CALL pas_admin_buscar_ingredientes(?)', [$searchTerm]);
        } else {
            $estadoInventario = DB::table('vw_admin_ingredientes')->get();
        }

        return view('admin.dashboardAdmin', [
            'ventasHoy' => $ventasHoy,
            'pedidosActivos' => $pedidosActivos,
            'totalProductos' => $totalProductos,
            'productosBajoStock' => $productosBajoStock,
            'empleados' => $empleados,
            'cajeros' => $cajeros,
            'reposteros' => $reposteros,
            'ventasPorMes' => $ventasPorMes,
            'productosMasVendidos' => $productosMasVendidos,
            'estadoInventario' => $estadoInventario,
        ]);
    }
}
