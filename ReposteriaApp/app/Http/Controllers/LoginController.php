<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $usuario = $request->usuario;
        $password = $request->password;

        // Intentar conectar a MySQL usando ese usuario
        try {
            config(['database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'username' => $usuario,
                'password' => $password,
            ]]);

            DB::connection('dynamic')->getPdo();

            // Si la conexión es exitosa, obtener los roles
            $grants = DB::connection('dynamic')->select('SHOW GRANTS FOR CURRENT_USER()');
            $role = null;

            foreach ($grants as $grant) {
                $grantString = array_values((array)$grant)[0];
                if (str_contains($grantString, 'role_admin')) {
                    $role = 'admin';
                    break;
                }
                if (str_contains($grantString, 'role_cajero')) {
                    $role = 'cajero';
                    break;
                }
                if (str_contains($grantString, 'role_repostero')) {
                    $role = 'repostero';
                    break;
                }
            }

            if ($role) {
                Session::put('user_role', $role);
                Session::put('user_name', $usuario);

                switch ($role) {
                    case 'admin':
                        return redirect('/admin/dashboard');
                    case 'cajero':
                        return redirect('/cajero/dashboard');
                    case 'repostero':
                        return redirect('/repostero/dashboard');
                }
            }

            return back()->with('error', 'Rol no reconocido para este usuario.');

        } catch (\Exception $e) {
            // Log the exception for debugging if needed
            // Log::error($e->getMessage());
            return back()->with('error', 'Identificación o contraseña incorrectos');
        }
    }

    public function logout(Request $request)
    {
        Session::forget(['user_role', 'user_name']);
        Session::flush();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
