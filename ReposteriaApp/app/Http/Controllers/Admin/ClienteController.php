<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido; // Added this line
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
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

        $cliente = Cliente::create($request->all());

        if ($request->input('from') === 'pedidos') {
            return dd(route('admin.pedidos.create', ['cli_cedula' => $cliente->cli_cedula]));
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
    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'cli_cedula' => 'required|string|digits:10|unique:cliente,cli_cedula,' . $cliente->cli_cedula . ',cli_cedula',
            'cli_nom' => 'required|string',
            'cli_apellido' => 'required|string',
            'cli_tel' => 'required|string|digits:10',
            'cli_dir' => 'nullable|string'
        ]);

        $cliente->update($request->all());

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        // Check if the client has associated orders
        if ($cliente->pedidos()->exists()) {
            return redirect()->route('admin.clientes.index')
                             ->with('error', 'Este cliente tiene pedidos asociados y no puede ser eliminado.');
        }

        $cliente->delete();

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente eliminado');
    }
}
