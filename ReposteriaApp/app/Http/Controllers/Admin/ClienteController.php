<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido; // Added this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search_client');

        if ($searchTerm) {
            $clientes = DB::select('CALL pas_admin_buscar_clientes(?)', [$searchTerm]);
        } else {
            $clientes = DB::table('vw_admin_clientes')->get();
        }
        
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cedula = $request->query('cedula');
        $from = $request->query('from');
        return view('admin.clientes.create', compact('cedula', 'from'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cli_cedula' => 'required|string|digits:10|unique:cliente,cli_cedula',
            'cli_nom' => 'required|string',
            'cli_apellido' => 'required|string',
            'cli_tel' => 'required|string|digits:10',
            'cli_dir' => 'nullable|string'
        ]);

        DB::statement(
            'CALL pas_insert_cliente(?, ?, ?, ?, ?)',
            [
                $request->cli_cedula,
                $request->cli_nom,
                $request->cli_apellido,
                $request->cli_tel,
                $request->cli_dir
            ]
        );

        if ($request->input('from') === 'pedidos') {
            return dd(route('admin.pedidos.create', ['cli_cedula' => $request->cli_cedula]));
                             //->with('success', 'Cliente registrado con éxito.');
        }

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente registrado con éxito');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clienteResult = DB::select('CALL pas_find_cliente(?)', [$id]);

        if (empty($clienteResult)) {
            abort(404, 'Cliente no encontrado');
        }

        $cliente = $clienteResult[0];

        return view('admin.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cli_nom' => 'required|string',
            'cli_apellido' => 'required|string',
            'cli_tel' => 'required|string|digits:10',
            'cli_dir' => 'nullable|string'
        ]);

        DB::statement('CALL pas_actu_cliente(?, ?, ?, ?, ?)', [
            $id,
            $request->input('cli_nom'),
            $request->input('cli_apellido'),
            $request->input('cli_tel'),
            $request->input('cli_dir')
        ]);

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if the client has associated orders
        if (DB::table('Pedido')->where('cli_cedula', $id)->exists()) {
            return redirect()->route('admin.clientes.index')
                             ->with('error', 'Este cliente tiene pedidos asociados y no puede ser eliminado.');
        }

        DB::statement('CALL pas_delete_cliente(?)', [$id]);

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente eliminado');
    }
}
