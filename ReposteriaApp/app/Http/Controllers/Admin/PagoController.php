<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = DB::table('Pago as pa')
            ->join('Pedido as pe', 'pa.ped_id', '=', 'pe.ped_id')
            ->leftJoin('Cliente as c', 'pe.cli_cedula', '=', 'c.cli_cedula')
            ->select(
                'pa.pag_id',
                'pa.pag_fec',
                'pa.pag_hora',
                'pa.pag_metodo',
                'pa.ped_id',
                'pe.ped_total',
                'c.cli_nom',
                'c.cli_apellido'
            )
            ->orderByDesc('pa.pag_fec')
            ->orderByDesc('pa.pag_hora')
            ->get();

        return view('admin.pagos.index', compact('pagos'));
    }
}
