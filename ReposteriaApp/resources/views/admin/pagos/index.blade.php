<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos - Repostería</title>
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
                    <div class="header-title">Pagos</div>
                    <div class="header-subtitle">Cobros asociados a pedidos</div>
                </div>
            </div>

            <div class="table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>ID Pago</th>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Método</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Total Pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pagos as $pago)
                            <tr>
                                <td>{{ $pago->pag_id }}</td>
                                <td>#{{ $pago->ped_id }}</td>
                                <td>{{ trim(($pago->cli_nom ?? '') . ' ' . ($pago->cli_apellido ?? '')) ?: 'Cliente ocasional' }}</td>
                                <td>{{ $pago->pag_metodo }}</td>
                                <td>{{ $pago->pag_fec }}</td>
                                <td>{{ $pago->pag_hora }}</td>
                                <td>${{ number_format($pago->ped_total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">No hay pagos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
