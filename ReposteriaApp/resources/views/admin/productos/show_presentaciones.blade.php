<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentaciones de {{ $producto->pro_nom }} - Repostería</title>
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
                    <div class="header-title">Presentaciones de {{ $producto->pro_nom }}</div>
                    <div class="header-subtitle">Administra las presentaciones de este producto</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.productos.index') }}" class="cancel-button">Volver a Productos</a>
                </div>
            </div>
            
            <!-- Product Presentations List -->
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
                        <div class="inventory-title">Listado de Presentaciones</div>
                        <div class="inventory-actions">
                            <a href="{{ route('admin.productos.createPresentacion', $producto->pro_id) }}" class="primary-action-button">Nueva Presentación</a>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>Porciones</th>
                                    <th>Tamaño</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($producto->presentaciones as $presentacion)
                                    <tr>
                                        <td>{{ $presentacion->tamano->tam_porciones }}</td>
                                        <td>{{ $presentacion->tamano->tam_nom }}</td>
                                        <td>{{ $presentacion->prp_precio }}</td>
                                        <td>
                                            <a href="{{ route('admin.productos.edit', $presentacion->prp_id) }}" class="action-button edit-button">Editar</a>
                                            <form action="{{ route('admin.presentaciones.destroy', $presentacion->prp_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de eliminar esta presentación?')">Eliminar</button>
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
