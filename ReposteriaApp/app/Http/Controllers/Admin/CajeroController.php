<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cajero;
use App\Models\Empleado;
use App\Models\Pedido; // Added this line
use Illuminate\Http\Request;

class CajeroController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cajeros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|integer|unique:empleado,emp_id', // Added validation for emp_id
            'emp_nom' => 'required|string',
            'emp_tel' => 'required|string|digits:10',
            'caj_turno' => 'required|string|in:Mañana,Tarde,Noche',
        ]);

        // Create Empleado with the manually provided emp_id
        $empleado = Empleado::create([
            'emp_id' => $request->emp_id, // Use the provided emp_id
            'emp_nom' => $request->emp_nom,
            'emp_tel' => $request->emp_tel,
        ]);

        // Create Cajero using the provided emp_id
        Cajero::create([
            'emp_id' => $empleado->emp_id,
            'caj_turno' => $request->caj_turno,
        ]);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Cajero registrado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cajero = Cajero::with('empleado')->findOrFail($id);
        return view('admin.cajeros.edit', compact('cajero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cajero = Cajero::findOrFail($id);
        $empleado = $cajero->empleado;

        $request->validate([
            'emp_nom' => 'required|string',
            'emp_tel' => 'required|string|digits:10',
            'caj_turno' => 'required|string|in:Mañana,Tarde,Noche',
        ]);

        // Update Empleado
        $empleado->update([
            'emp_nom' => $request->emp_nom,
            'emp_tel' => $request->emp_tel,
        ]);

        // Update Cajero
        $cajero->update([
            'caj_turno' => $request->caj_turno,
        ]);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Cajero actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cajero = Cajero::findOrFail($id);

        // Check if the cashier has associated orders
        if ($cajero->pedidos()->exists()) {
            return redirect()->route('admin.empleados.index')
                             ->with('error', 'Este cajero tiene pedidos asociados y no puede ser eliminado.');
        }

        $empleado = $cajero->empleado; // Get the associated Empleado

        $cajero->delete(); // Delete Cajero record
        $empleado->delete(); // Delete Empleado record (Cajero will be cascaded)

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Cajero eliminado con éxito');
    }
}
