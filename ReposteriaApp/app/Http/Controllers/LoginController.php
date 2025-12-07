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

        try {
            // Configura una conexión de base de datos 'dinámica' utilizando las credenciales proporcionadas.
            // Esta conexión se usa para autenticar al usuario y determinar su rol.
            config(['database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'username' => $usuario,
                'password' => $password,
            ]]);

            // Intenta obtener una instancia PDO para la conexión 'dinámica'.
            // Si las credenciales son incorrectas, esto lanzará una excepción.
            DB::connection('dynamic')->getPdo();

            // Si la conexión es exitosa, se procede a obtener los roles del usuario
            // consultando los GRANTS de la base de datos.
            $grants = DB::connection('dynamic')->select('SHOW GRANTS FOR CURRENT_USER()');
            $role = null;

            // Itera sobre los grants para identificar el rol del usuario (admin, cajero, repostero).
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

            // Si se encontró un rol válido, guarda la información del usuario en la sesión
            // y redirige al dashboard correspondiente.
            if ($role) {
                Session::put('user_role', $role); // Guarda el rol del usuario en la sesión.
                Session::put('user_name', $usuario); // Guarda el nombre de usuario en la sesión.
                // Encripta y guarda la contraseña en la sesión. Se desencriptará en el middleware para
                // establecer la conexión de base de datos en cada solicitud subsiguiente.
                Session::put('user_password', encrypt($password)); 

                switch ($role) {
                    case 'admin':
                        return redirect('/admin/dashboard');
                    case 'cajero':
                        return redirect('/cajero/dashboard');
                    case 'repostero':
                        return redirect('/repostero/dashboard');
                }
            }

            // Si no se reconoce el rol asignado al usuario, redirige con un mensaje de error.
            return back()->with('error', 'Rol no reconocido para este usuario.');

        } catch (\Exception $e) {
            // En caso de que la conexión falle (credenciales incorrectas), redirige con un error.
            // Log::error($e->getMessage()); // Se puede descomentar para registrar el error.
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
