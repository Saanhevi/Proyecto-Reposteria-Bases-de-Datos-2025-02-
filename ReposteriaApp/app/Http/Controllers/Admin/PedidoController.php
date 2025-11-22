<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Cajero;
use App\Models\DetallePedido;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = DB::table('vw_admin_pedidos_realizados')->get();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::with('presentaciones.tamano')->get();
        $cajeros = Cajero::with('empleado')->get();
        $cli_cedula = request()->query('cli_cedula'); // Get cli_cedula from query
        return view('admin.pedidos.create', compact('clientes', 'productos', 'cajeros', 'cli_cedula'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cli_cedula' => 'required|exists:cliente,cli_cedula',
            'emp_id' => 'required|exists:cajero,emp_id',
            'items' => 'required|array|min:1',
            'items.*.prp_id' => 'required|exists:productopresentacion,prp_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Calculate total on the server
                $total = 0;
                foreach ($request->items as $item) {
                    $total += $item['quantity'] * $item['price'];
                }

                // 2. Create the Pedido
                $pedido = Pedido::create([
                    'cli_cedula' => $request->cli_cedula,
                    'emp_id' => $request->emp_id,
                    'ped_fec' => now()->toDateString(),
                    'ped_hora' => now()->toTimeString(),
                    'ped_est' => 'Pendiente',
                    'ped_total' => $total,
                ]);

                // 3. Create the DetallePedido records
                foreach ($request->items as $item) {
                    DetallePedido::create([
                        'ped_id' => $pedido->ped_id,
                        'prp_id' => $item['prp_id'],
                        'dpe_can' => $item['quantity'],
                        'dpe_subtotal' => $item['quantity'] * $item['price'],
                    ]);
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el pedido: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido creado con éxito.');
    }

    public function show(Pedido $pedido)
    {
        // Eager load relationships
        $pedido->load('cliente', 'cajero.empleado', 'detalles.productoPresentacion.producto', 'detalles.productoPresentacion.tamano');
        
        return view('admin.pedidos.show', compact('pedido'));
    }
}