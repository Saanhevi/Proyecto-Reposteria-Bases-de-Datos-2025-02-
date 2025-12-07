<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SetDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario ha iniciado sesión y si sus credenciales están en la sesión.
        if (Session::has('user_name') && Session::has('user_password')) {
            $username = Session::get('user_name');
            // Desencripta la contraseña del usuario almacenada en la sesión.
            $password = decrypt(Session::get('user_password'));

            // Configura dinámicamente una nueva conexión de base de datos 'dynamic'
            // utilizando las credenciales del usuario autenticado.
            config(['database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'username' => $username,
                'password' => $password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
            ]]);

            // Establece la conexión 'dynamic' como la conexión por defecto para la solicitud actual.
            config(['database.default' => 'dynamic']);
            // Purga la conexión 'dynamic' para asegurar que se use la nueva configuración.
            DB::purge('dynamic');
        }

        return $next($request);
    }
}
