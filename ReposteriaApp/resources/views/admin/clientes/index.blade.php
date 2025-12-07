<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/BotonStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search-styles.css') }}">
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
                    <div class="header-title">Gestión de Clientes</div>
                    <div class="header-subtitle">Crea, edita y elimina clientes</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.clientes.create') }}" class="primary-action-button">Nuevo Cliente</a>
                </div>
            </div>

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

            <!-- Search bar -->
            <div class="card" style="margin-bottom: 24px; background: white; border-radius: 12px; border: 1px solid #E8DCC0; padding: 25px;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0;">
                    <h3 class="chart-title">Buscar Clientes</h3>
                    <div class="inventory-search-container">
                        <form action="{{ route('admin.clientes.index') }}" method="GET" style="display: flex; gap: 8px;">
                            <div class="inventory-search-input-wrapper">
                                <span class="inventory-search-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                                <input type="search" name="search_client" class="inventory-search-input" placeholder="Buscar por nombre o cédula..." value="{{ request('search_client') }}">
                            </div>
                            <button type="submit" class="primary-action-button btn-small">Buscar</button>
                            <a href="{{ route('admin.clientes.index') }}" class="cancel-button btn-small">Limpiar</a>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Client Table -->
            <div class="table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->cli_cedula }}</td>
                                <td>{{ $cliente->cli_nom }}</td>
                                <td>{{ $cliente->cli_apellido }}</td>
                                <td>{{ $cliente->cli_tel }}</td>
                                <td>{{ $cliente->cli_dir }}</td>
                                <td>
                                    <a href="{{ route('admin.clientes.edit', $cliente->cli_cedula) }}" class="action-button edit-button">Editar</a>
                                    <form action="{{ route('admin.clientes.destroy', $cliente->cli_cedula) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-button delete-button" onclick="return confirm('¿Está seguro de que desea eliminar este cliente y todos sus datos asociados?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>