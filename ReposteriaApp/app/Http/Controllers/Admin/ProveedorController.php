<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = \App\Models\Proveedor::all();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'prov_nom' => 'required|string|unique:proveedor,prov_nom',
            'prov_tel' => 'required|string|digits:10',
            'prov_dir' => 'required|string'
        ]);

        \App\Models\Proveedor::create($request->all());

        return redirect()->route('admin.proveedores.index')
                         ->with('success', 'Proveedor registrado con éxito');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proveedor = \App\Models\Proveedor::findOrFail($id);
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $proveedor = \App\Models\Proveedor::findOrFail($id);

        $request->validate([
            'prov_nom' => 'required|string|unique:proveedor,prov_nom,' . $proveedor->prov_id . ',prov_id',
            'prov_tel' => 'required|string|digits:10',
            'prov_dir' => 'required|string'
        ]);

        $proveedor->update($request->all());

        return redirect()->route('admin.proveedores.index')
                         ->with('success', 'Proveedor actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = \App\Models\Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('admin.proveedores.index')
                         ->with('success', 'Proveedor eliminado con éxito');
    }
}
