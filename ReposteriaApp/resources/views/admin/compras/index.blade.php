<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras - Repostería</title>
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
                    <div class="header-title">Compras</div>
                    <div class="header-subtitle">Historial de compras a proveedores</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.compras.create') }}" class="primary-action-button">Nueva compra</a>
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

            <div class="table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>ID Compra</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Total</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($compras as $compra)
                            <tr>
                                <td>{{ $compra->com_id }}</td>
                                <td>{{ $compra->com_fec }}</td>
                                <td>{{ $compra->prov_nom }}</td>
                                <td>${{ number_format($compra->com_tot, 0, ',', '.') }}</td>
                                <td class="actions">
                                    <a href="{{ route('admin.compras.show', $compra->com_id) }}" class="action-button">Ver</a>
                                    <a href="{{ route('admin.compras.edit', $compra->com_id) }}" class="action-button edit-button">Editar</a>
                                    <form action="{{ route('admin.compras.destroy', $compra->com_id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de que quieres eliminar esta compra?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No hay compras registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination-container">
                    {{ $compras->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
