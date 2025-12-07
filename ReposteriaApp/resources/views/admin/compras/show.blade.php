<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Compra #{{ $compra->com_id }} - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/createRecetaStyles.css') }}">
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <div class="main-content">
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Detalle de Compra #{{ $compra->com_id }}</div>
                    <div class="header-subtitle">Información detallada de la compra.</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.compras.index') }}" class="cancel-button">Volver</a>
                    <a href="{{ route('admin.compras.edit', $compra->com_id) }}" class="primary-action-button">Editar Compra</a>
                </div>
            </div>

            <div class="form-container" style="max-width: 1200px; margin: 24px auto;">
                <div class="form-group">
                    <label class="form-label">ID de Compra</label>
                    <p class="form-input-static">{{ $compra->com_id }}</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Proveedor</label>
                    <p class="form-input-static">{{ $proveedor->prov_nom }}</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Fecha y Hora</label>
                    <p class="form-input-static">{{ \Carbon\Carbon::parse($compra->com_fec)->format('Y-m-d H:i') }}</p>
                </div>

                <h3 class="summary-title">Ingredientes Comprados</h3>
                <div class="table-container" style="padding:0;">
                    <table class="inventory-table" id="detalle-table">
                        <thead>
                            <tr>
                                <th>Ingrediente</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->ing_nom }}</td>
                                    <td>{{ $detalle->dco_can }}</td>
                                    <td>${{ number_format($detalle->dco_pre, 0, ',', '.') }}</td>
                                    <td>${{ number_format($detalle->dco_can * $detalle->dco_pre, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">No hay ingredientes detallados para esta compra.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="summary-total" style="margin-top: 20px;">
                    <span class="total-label">Total de la Compra:</span>
                    <span class="total-value" id="total-compra">${{ number_format($compra->com_tot, 0, ',', '.') }}</span>
                </div>

                <div class="form-actions" style="margin-top: 24px;">
                    <a href="{{ route('admin.compras.index') }}" class="cancel-button">Volver al Listado</a>
                    <a href="{{ route('admin.compras.edit', $compra->com_id) }}" class="primary-action-button">Editar Compra</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>