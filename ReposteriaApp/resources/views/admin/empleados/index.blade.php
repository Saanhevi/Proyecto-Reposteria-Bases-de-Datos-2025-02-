<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/BotonStyle.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Gestión de Empleados</div>
                    <div class="header-subtitle">Administra la información de los empleados por rol</div>
                </div>
                <div class="header-actions">
                </div>
            </div>
            
            <!-- Empleados List -->
            <div class="dashboard-content">
                @if (session('success'))
                    <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Cajeros Section --}}
                <div class="inventory-card">
                    <div class="inventory-header">
                        <div class="inventory-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-right: 8px;">
                                <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V8H20V18ZM10 10H14V12H10V10ZM10 14H14V16H10V14Z" fill="#1F2937"/>
                            </svg>
                            Listado de Cajeros
                        </div>
                        <div class="inventory-actions">
                            <a href="{{ route('admin.cajeros.create') }}" class="primary-action-button">Nuevo Cajero</a>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Turno</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cajeros as $cajero)
                                    <tr>
                                        <td>{{ $cajero->emp_id }}</td>
                                        <td>{{ $cajero->empleado->emp_nom }}</td>
                                        <td>{{ $cajero->empleado->emp_tel }}</td>
                                        <td>{{ $cajero->caj_turno }}</td>
                                        <td>
                                            <a href="{{ route('admin.cajeros.edit', $cajero->emp_id) }}" class="action-button edit-button">Editar</a>
                                            <form action="{{ route('admin.cajeros.destroy', $cajero->emp_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de eliminar este cajero?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Reposteros Section --}}
                <div class="inventory-card">
                    <div class="inventory-header">
                        <div class="inventory-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-right: 8px;">
                                <path d="M12 0C8.69 0 6 2.69 6 6V10H18V6C18 2.69 15.31 0 12 0ZM12 2C14.21 2 16 3.79 16 6V8H8V6C8 3.79 9.79 2 12 2ZM4 12V22H20V12H4ZM6 14H18V20H6V14Z" fill="#1F2937"/>
                            </svg>
                            Listado de Reposteros
                        </div>
                        <div class="inventory-actions">
                            <a href="{{ route('admin.reposteros.create') }}" class="primary-action-button">Nuevo Repostero</a>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Especialidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reposteros as $repostero)
                                    <tr>
                                        <td>{{ $repostero->emp_id }}</td>
                                        <td>{{ $repostero->empleado->emp_nom }}</td>
                                        <td>{{ $repostero->empleado->emp_tel }}</td>
                                        <td>{{ $repostero->rep_especialidad }}</td>
                                        <td>
                                            <a href="{{ route('admin.reposteros.edit', $repostero->emp_id) }}" class="action-button edit-button">Editar</a>
                                            <form action="{{ route('admin.reposteros.destroy', $repostero->emp_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de eliminar este repostero?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Domiciliarios Section --}}
                <div class="inventory-card">
                    <div class="inventory-header">
                        <div class="inventory-title">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-right: 8px;">
                                <path d="M12 2C8.69 2 6 4.69 6 8V12H18V8C18 4.69 15.31 2 12 2ZM12 4C14.21 4 16 5.79 16 8V10H8V8C8 5.79 9.79 4 12 4ZM4 14V22H20V14H4ZM6 16H18V20H6V16Z" fill="#1F2937"/>
                            </svg>
                            Listado de Domiciliarios
                        </div>
                        <div class="inventory-actions">
                            <a href="{{ route('admin.domiciliarios.create') }}" class="primary-action-button">Nuevo Domiciliario</a>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Medio de Transporte</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($domiciliarios as $domiciliario)
                                    <tr>
                                        <td>{{ $domiciliario->emp_id }}</td>
                                        <td>{{ $domiciliario->empleado->emp_nom }}</td>
                                        <td>{{ $domiciliario->empleado->emp_tel }}</td>
                                        <td>{{ $domiciliario->dom_medTrans }}</td>
                                        <td>
                                            <a href="{{ route('admin.domiciliarios.edit', $domiciliario->emp_id) }}" class="action-button edit-button">Editar</a>
                                            <form action="{{ route('admin.domiciliarios.destroy', $domiciliario->emp_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de eliminar este domiciliario?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
