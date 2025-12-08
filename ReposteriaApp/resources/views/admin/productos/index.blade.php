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
        @include('admin.partials.sidebar')

        <div class="main-content">
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Gestión de productos</div>
                    <div class="header-subtitle">Administra recetas base y presentaciones</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.productos.create') }}" class="primary-action-button">Nuevo producto</a>
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
                            <div class="inventory-title">Listado de productos</div>
                            <div class="inventory-subtitle">Incluye receta base y número de presentaciones</div>
                        </div>
                    </div>

                    @if ($productos->isEmpty())
                        <div class="empty-state" style="padding: 24px;">Aún no hay productos registrados.</div>
                    @else
                        <div class="table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Receta base</th>
                                        <th>Presentaciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->pro_id }}</td>
                                            <td>
                                                <div class="table-title">{{ $producto->pro_nom }}</div>
                                                <div class="table-subtitle">ID: {{ $producto->pro_id }}</div>
                                            </td>
                                            <td>{{ $producto->receta->rec_nom ?? 'Sin receta' }}</td>
                                            <td>
                                                <span class="badge">{{ $producto->presentaciones_count }} {{ \Illuminate\Support\Str::plural('presentación', $producto->presentaciones_count) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.productos.showPresentaciones', $producto->pro_id) }}" class="action-button edit-button">Ver presentaciones</a>
                                                <form action="{{ route('admin.productos.destroy', $producto->pro_id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de eliminar este producto y todas sus presentaciones?')">Eliminar</button>
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
        .table-title { font-weight: 600; }
        .table-subtitle { font-size: 12px; color: #6b7280; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; background: #eef2ff; color: #4338ca; font-weight: 600; font-size: 12px; }
    </style>
</body>
</html>
