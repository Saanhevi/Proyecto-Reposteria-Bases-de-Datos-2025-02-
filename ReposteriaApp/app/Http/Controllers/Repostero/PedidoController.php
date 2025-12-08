<?php

namespace App\Http\Controllers\Repostero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    public function preparar($pedidoId)
    {
        try {
            DB::statement('CALL pas_repostero_preparar_pedido(?)', [$pedidoId]);
        } catch (\Throwable $e) {
            Log::warning('No se pudo preparar pedido '.$pedidoId.': '.$e->getMessage());
            return redirect()->route('repostero.dashboard')->with('error', 'No se pudo preparar el pedido (verifica stock).');
        }

        return redirect()->route('repostero.dashboard')->with('success', 'Pedido actualizado a Preparado.');
    }
}
