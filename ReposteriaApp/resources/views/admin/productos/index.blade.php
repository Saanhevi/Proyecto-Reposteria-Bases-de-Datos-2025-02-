<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Repostería</title>
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
                    <div class="header-title">Gestión de Productos</div>
                    <div class="header-subtitle">Administra la información de los productos</div>
                </div>
                <div class="header-actions">
                </div>
            </div>
            
            <!-- Products List -->
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
                <div class="inventory-card">
                    <div class="inventory-header">
                        <div class="inventory-title">Listado de Productos</div>
                        <div class="inventory-actions">
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->pro_id }}</td>
                                        <td>{{ $producto->pro_nom }}</td>
                                        <td>
                                            <a href="{{ route('admin.productos.showPresentaciones', $producto->pro_id) }}" class="action-button edit-button">Mostrar Presentaciones</a>
                                            <form action="{{ route('admin.productos.destroy', $producto->pro_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de eliminar este producto y todas sus presentaciones?')">Eliminar Producto</button>
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
