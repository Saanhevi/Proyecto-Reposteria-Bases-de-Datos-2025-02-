<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido - Repostería</title>
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
                    <div class="header-title">Detalle del Pedido #{{ $pedido->ped_id }}</div>
                    <div class="header-subtitle">Información completa del pedido y cliente.</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.pedidos.index') }}" class="action-button edit-button">Volver a Pedidos</a>
                </div>
            </div>
            
            <div class="dashboard-content">
                <div class="info-card-grid">
                    <!-- Order Summary Card -->
                    <div class="info-card">
                        <h3 class="info-card-title">Resumen del Pedido</h3>
                        <div class="info-card-item">
                            <span class="info-card-label">ID Pedido:</span>
                            <span class="info-card-value">#{{ $pedido->ped_id }}</span>
                        </div>
                        <div class="info-card-item">
                            <span class="info-card-label">Fecha y Hora:</span>
                            <span class="info-card-value">{{ $pedido->ped_fec }} {{ $pedido->ped_hora }}</span>
                        </div>
                        <div class="info-card-item">
                            <span class="info-card-label">Estado:</span>
                            <span class="info-card-value">
                                <span class="status-badge {{ $pedido->ped_est }}">{{ $pedido->ped_est }}</span>
                            </span>
                        </div>
                        <div class="info-card-item">
                            <span class="info-card-label">Cajero:</span>
                            <span class="info-card-value">{{ $pedido->cajero->empleado->emp_nom ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Client Info Card -->
                    <div class="info-card">
                        <h3 class="info-card-title">Información del Cliente</h3>
                        <div class="info-card-item">
                            <span class="info-card-label">Nombre:</span>
                            <span class="info-card-value">{{ $pedido->cliente->cli_nom }} {{ $pedido->cliente->cli_apellido }}</span>
                        </div>
                        <div class="info-card-item">
                            <span class="info-card-label">Cédula:</span>
                            <span class="info-card-value">{{ $pedido->cliente->cli_cedula }}</span>
                        </div>
                        <div class="info-card-item">
                            <span class="info-card-label">Teléfono:</span>
                            <span class="info-card-value">{{ $pedido->cliente->cli_tel }}</span>
                        </div>
                        <div class="info-card-item">
                            <span class="info-card-label">Dirección:</span>
                            <span class="info-card-value">{{ $pedido->cliente->cli_dir ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="inventory-card">
                    <div class="inventory-header">
                        <div class="inventory-title">Productos en el Pedido</div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Presentación</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pedido->detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->productoPresentacion->producto->pro_nom }}</td>
                                        <td>{{ $detalle->productoPresentacion->tamano->tam_nom }}</td>
                                        <td>{{ $detalle->dpe_can }}</td>
                                        <td>${{ number_format($detalle->dpe_subtotal / $detalle->dpe_can, 0, ',', '.') }}</td>
                                        <td>${{ number_format($detalle->dpe_subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Este pedido no tiene productos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right; font-weight: bold; padding-right: 16px;">Total del Pedido:</td>
                                    <td style="font-weight: bold;">${{ number_format($pedido->ped_total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
