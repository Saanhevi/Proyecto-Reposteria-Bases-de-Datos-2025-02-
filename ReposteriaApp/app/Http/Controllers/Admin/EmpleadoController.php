<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cajero; // Import Cajero model
use App\Models\Repostero; // Import Repostero model
use App\Models\Domiciliario; // Import Domiciliario model
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cajeros = Cajero::with('empleado')->get();
        $reposteros = Repostero::with('empleado')->get();
        $domiciliarios = Domiciliario::with('empleado')->get();

        return view('admin.empleados.index', compact('cajeros', 'reposteros', 'domiciliarios'));
    }
}
