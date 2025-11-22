<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repostero;
use App\Models\Empleado;
use Illuminate\Http\Request;

class ReposteroController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reposteros.create');
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
            'rep_especialidad' => 'nullable|string',
        ]);

        // Create Empleado with the manually provided emp_id
        $empleado = Empleado::create([
            'emp_id' => $request->emp_id, // Use the provided emp_id
            'emp_nom' => $request->emp_nom,
            'emp_tel' => $request->emp_tel,
        ]);

        // Create Repostero using the provided emp_id
        Repostero::create([
            'emp_id' => $empleado->emp_id,
            'rep_especialidad' => $request->rep_especialidad,
        ]);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Repostero registrado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $repostero = Repostero::with('empleado')->findOrFail($id);
        return view('admin.reposteros.edit', compact('repostero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $repostero = Repostero::findOrFail($id);
        $empleado = $repostero->empleado;

        $request->validate([
            'emp_nom' => 'required|string',
            'emp_tel' => 'required|string|digits:10',
            'rep_especialidad' => 'nullable|string',
        ]);

        // Update Empleado
        $empleado->update([
            'emp_nom' => $request->emp_nom,
            'emp_tel' => $request->emp_tel,
        ]);

        // Update Repostero
        $repostero->update([
            'rep_especialidad' => $request->rep_especialidad,
        ]);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Repostero actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $repostero = Repostero::findOrFail($id);
        $empleado = $repostero->empleado; // Get the associated Empleado

        $repostero->delete(); // Delete Repostero record
        $empleado->delete(); // Delete Empleado record (Repostero will be cascaded)

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Repostero eliminado con éxito');
    }
}
