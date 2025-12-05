<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores - Repostería</title>
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
                    <div class="header-title">Gestión de Proveedores</div>
                    <div class="header-subtitle">Crea, edita y elimina proveedores</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.proveedores.create') }}" class="primary-action-button">Nuevo Proveedor</a>
                </div>
            </div>
            
            <!-- Proveedor Table -->
            <div class="table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $proveedor)
                            <tr>
                                <td>{{ $proveedor->prov_id }}</td>
                                <td>{{ $proveedor->prov_nom }}</td>
                                <td>{{ $proveedor->prov_tel }}</td>
                                <td>{{ $proveedor->prov_dir }}</td>
                                <td>
                                    <a href="{{ route('admin.proveedores.edit', $proveedor->prov_id) }}" class="action-button edit-button">Editar</a>
                                    <form action="{{ route('admin.proveedores.destroy', $proveedor->prov_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-button delete-button" onclick="return confirm('¿Está seguro de que desea eliminar este proveedor y todos sus datos asociados?')">Eliminar</button>
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