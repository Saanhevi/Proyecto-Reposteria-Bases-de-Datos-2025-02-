<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Repostería</title>
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
                    <div class="header-title">Gestión de Pedidos</div>
                    <div class="header-subtitle">Visualiza todos los pedidos realizados</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.pedidos.create') }}" class="primary-action-button">Nuevo Pedido</a>
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
            
            <!-- Pedidos Table -->
            <div class="table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Cliente</th>
                            <th>Cajero</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->cli_cedula }}</td>
                                <td>{{ $pedido->cli_nombre_completo }}</td>
                                <td>{{ $pedido->cajero_nom ?? 'N/A' }}</td>
                                <td>{{ $pedido->ped_fec }}</td>
                                <td>{{ $pedido->ped_hora }}</td>
                                <td>
                                    <span class="status-badge {{ $pedido->ped_est }}">{{ $pedido->ped_est }}</span>
                                </td>
                                <td>${{ number_format($pedido->ped_total, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.pedidos.show', $pedido->ped_id) }}" class="action-button edit-button">Ver Detalle</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No hay pedidos para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
