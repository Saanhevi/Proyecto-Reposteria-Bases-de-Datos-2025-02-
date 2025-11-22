<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domiciliario;
use App\Models\Empleado;
use Illuminate\Http\Request;

class DomiciliarioController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.domiciliarios.create');
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
            'dom_medTrans' => 'nullable|string|in:Bicicleta,Moto',
        ]);

        // Create Empleado with the manually provided emp_id
        $empleado = Empleado::create([
            'emp_id' => $request->emp_id, // Use the provided emp_id
            'emp_nom' => $request->emp_nom,
            'emp_tel' => $request->emp_tel,
        ]);

        // Create Domiciliario using the provided emp_id
        Domiciliario::create([
            'emp_id' => $empleado->emp_id,
            'dom_medTrans' => $request->dom_medTrans,
        ]);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Domiciliario registrado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $domiciliario = Domiciliario::with('empleado')->findOrFail($id);
        return view('admin.domiciliarios.edit', compact('domiciliario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $domiciliario = Domiciliario::findOrFail($id);
        $empleado = $domiciliario->empleado;

        $request->validate([
            'emp_nom' => 'required|string',
            'emp_tel' => 'required|string|digits:10',
            'dom_medTrans' => 'nullable|string|in:Bicicleta,Moto',
        ]);

        // Update Empleado
        $empleado->update([
            'emp_nom' => $request->emp_nom,
            'emp_tel' => $request->emp_tel,
        ]);

        // Update Domiciliario
        $domiciliario->update([
            'dom_medTrans' => $request->dom_medTrans,
        ]);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Domiciliario actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $domiciliario = Domiciliario::findOrFail($id);
        $empleado = $domiciliario->empleado; // Get the associated Empleado

        $domiciliario->delete(); // Delete Domiciliario record
        $empleado->delete(); // Delete Empleado record (Domiciliario will be cascaded)

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Domiciliario eliminado con éxito');
    }
}
