# Reposteria App

## Descripción del Proyecto

Esta es una aplicación web desarrollada con el framework Laravel (PHP) para la gestión de una repostería. Permite administrar clientes, productos, pedidos, empleados (cajeros, reposteros, domiciliarios) y proveedores, entre otras funcionalidades.

## Características Principales

*   Gestión de Clientes
*   Gestión de Pedidos y Detalles de Pedido
*   Gestión de Productos y sus Presentaciones
*   Administración de Empleados por Rol (Cajeros, Reposteros)
*   Gestión de Proveedores e Ingredientes
*   Autenticación de Usuarios por Rol

## Requisitos del Sistema

Para poder instalar y ejecutar esta aplicación, necesitarás tener los siguientes componentes instalados en tu sistema operativo (asumiendo Windows):

1.  **PHP (versión 8.2 o superior):** Laravel 12 requiere PHP 8.2 o superior.
    *   **Extensiones de PHP requeridas:** `pdo_mysql`, `mbstring`, `xml`, `curl`, `gd`, `json`, `fileinfo`, `tokenizer`, `bcmath`.
2.  **Composer:** Herramienta para la gestión de dependencias de PHP.
3.  **Base de Datos MySQL (versión 8.0 o superior)** Para almacenar los datos de la aplicación.
4.  **Node.js (versión 18 o superior) y npm:** Necesarios para compilar los recursos frontend de la aplicación (CSS, JavaScript).
5.  **Git:** Opcional, pero recomendado para clonar el repositorio del proyecto.

---

### **Cómo instalar los requisitos**

1.  **Instalar PHP:**
    *   Descarga PHP 8.2+ desde [https://windows.php.net/download/](https://windows.php.net/download/).
    *   Descomprime el archivo ZIP en una carpeta (ej. `C:\php`).
    *   Añade la ruta de PHP a tus variables de entorno `PATH`.
    *   Habilita las extensiones necesarias editando el archivo `php.ini` (busca las líneas que empiezan con `extension=` y descomenta las requeridas, eliminando el `;` al inicio).
2.  **Instalar MySQL:**
    *   Descarga MySQL Community Server desde [https://dev.mysql.com/downloads/mysql/](https://dev.mysql.com/downloads/mysql/).
    *   Sigue las instrucciones del instalador.
3.  **Instalar Composer:**
    *   Descarga e instala el `Composer-Setup.exe` desde [https://getcomposer.org/download/](https://getcomposer.org/download/).
    *   Durante la instalación, asegúrate de que se detecte tu instalación de PHP.
    *   Verifica la instalación abriendo CMD/PowerShell y escribiendo `composer -v`.
4.  **Instalar Node.js y npm:**
    *   Descarga el instalador recomendado desde [https://nodejs.org/es/download/](https://nodejs.org/es/download/).
    *   Sigue las instrucciones. `npm` se instala junto con Node.js.
    *   Verifica la instalación abriendo CMD/PowerShell y escribiendo `node -v` y `npm -v`.

---

## Instalación del Proyecto

Una vez que todos los requisitos estén instalados:

1.  **Descargar el Proyecto:**
    *   Si tienes Git: Abre tu terminal (CMD o PowerShell) y navega hasta el directorio donde quieres guardar el proyecto. Luego, ejecuta:
        ```bash
        git clone [https://github.com/Saanhevi/Proyecto-Reposteria-Bases-de-Datos-2025-02-.git] "Proyecto Bases de Datos"
        ```
    *   Si no tienes Git: Simplemente descarga los archivos del proyecto (archivo `.zip`) y descomprímelos en una carpeta llamada `Proyecto Bases de Datos`.

2.  **Navegar al Directorio de la Aplicación Laravel:**
    ```bash
    cd "Proyecto Bases de Datos/ReposteriaApp"
    ```

3.  **Instalar Dependencias de PHP:**
    ```bash
    composer install
    ```

4.  **Configurar el Entorno:**
    *   Copia el archivo de ejemplo `.env.example` para crear tu archivo de configuración `.env`:
        ```bash
        copy .env.example .env
        ```
    *   Genera la clave de aplicación de Laravel (esto es crucial para la seguridad):
        ```bash
        php artisan key:generate
        ```

5.  **Configurar el Archivo `.env`:**
    *   Abre el archivo `.env` con un editor de texto (como Visual Studio Code).
    *   **Configuración de la Base de Datos:**
        *   `DB_CONNECTION=mysql` (Conexion en MySQL)
        *   `DB_HOST=127.0.0.1` 
        *   `DB_PORT=3306` 
        *   `DB_DATABASE=reposteriadb` (El nombre de tu base de datos)
        *   `DB_USERNAME=root` (o el usuario de tu base de datos)
        *   `DB_PASSWORD=TuContraseña` (la contraseña de tu base de datos)
    *   **Configuración de la Zona Horaria :** Para evitar problemas con la hora, ajusta tu zona horaria. Por ejemplo:
        ```
        APP_TIMEZONE="America/Bogota"
        ```

6.  **Instalar Dependencias de Node.js:**
    ```bash
    npm install
    ```

7.  **Compilar Recursos Frontend:**
    ```bash
    npm run build
    ```

## Configuración de la Base de Datos

1.  **Crear la Base de Datos:**
    *   Abre tu cliente de MySQL (MySQL Workbench, o la línea de comandos de MySQL).

2.  **Ejecutar Scripts SQL:**
    *   En tu cliente de MySQL, selecciona la base de datos `ReposteriaDB`.
    *   Ejecuta los siguientes scripts SQL en el ORDEN ESPECIFICADO:
        1.  `CreacionTablas.sql → InsercionDatos.sql → CreacionVistas.sql → ScriptFunciones.sql → ScriptProcedimientosAlmacenados.sql → ScriptIndices.sql → CreacionUsuariosPerfiles.sql (y los demás scripts de ejemplo según necesites).`

        **Nota:** El script `CreacionUsuariosPerfiles.sql` crea usuarios y roles específicos para la aplicación. Asegúrate de entender su contenido si deseas modificar los usuarios o las contraseñas.

3.  **Ejecutar Migraciones de Laravel:**
    *   Desde el directorio `ReposteriaApp` en tu terminal, ejecuta:
        ```bash
        php artisan migrate
        ```
        Esto asegurará que la estructura de la base de datos esté sincronizada con los modelos de Laravel.

## Ejecutar la Aplicación

1.  Desde el directorio `ReposteriaApp` en tu terminal, ejecuta:
    ```bash
    php artisan serve
    ```
2.  Abre tu navegador web y visita la URL que te proporcionará Artisan (generalmente `http://127.0.0.1:8000`).

---
