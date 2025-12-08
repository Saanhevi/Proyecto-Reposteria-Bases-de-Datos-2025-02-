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
        @include('admin.partials.sidebar')

        <div class="main-content">
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Presentaciones de {{ $producto->pro_nom }}</div>
                    <div class="header-subtitle">Receta base: {{ $producto->receta->rec_nom ?? 'Sin receta asignada' }}</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.productos.index') }}" class="cancel-button">Volver a productos</a>
                </div>
            </div>

            <div class="dashboard-content">
                @if (session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert error">{{ session('error') }}</div>
                @endif

                <div class="inventory-card">
                    <div class="inventory-header">
                        <div>
                            <div class="inventory-title">Listado de presentaciones</div>
                            <div class="inventory-subtitle">El factor se aplica sobre la receta base.</div>
                        </div>
                        <div class="inventory-actions">
                            <a href="{{ route('admin.productos.createPresentacion', $producto->pro_id) }}" class="primary-action-button">Nueva presentación</a>
                        </div>
                    </div>

                    @if ($producto->presentaciones->isEmpty())
                        <div class="empty-state" style="padding: 24px;">
                            No hay presentaciones registradas para este producto.
                            <div style="margin-top: 8px;">
                                <a href="{{ route('admin.productos.createPresentacion', $producto->pro_id) }}" class="primary-action-button">Agregar la primera presentación</a>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th>Tamaño</th>
                                        <th>Porciones</th>
                                        <th>Factor</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($producto->presentaciones as $presentacion)
                                        <tr>
                                            <td>{{ $presentacion->tamano->tam_nom }}</td>
                                            <td>{{ $presentacion->tamano->tam_porciones }}</td>
                                            <td>x{{ $presentacion->tamano->tam_factor }}</td>
                                            <td>${{ number_format($presentacion->prp_precio, 0, ',', '.') }}</td>
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .alert { padding: 12px 14px; border-radius: 8px; margin-bottom: 14px; border: 1px solid transparent; }
        .alert.success { background: #e6f7f0; color: #065f46; border-color: #a7f3d0; }
        .alert.error { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        .inventory-subtitle { color: #6b7280; font-size: 14px; }
    </style>
</body>
</html>
