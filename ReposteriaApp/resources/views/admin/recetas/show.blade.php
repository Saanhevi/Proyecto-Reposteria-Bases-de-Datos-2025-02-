<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Receta - Repostería</title>
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
                    <div class="header-title">Detalle de la Receta</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.recetas.index') }}" class="action-button edit-button">Volver al Listado</a>
                </div>
            </div>

            <div class="dashboard-content">
                <div class="info-card">
                    <h3 class="info-card-title">Resumen de la Receta</h3>
                    <div class="info-card-item">
                        <span class="info-card-label">ID Receta:</span>
                        <span class="info-card-value">#{{ $receta->rec_id }}</span>
                    </div>
                    <div class="info-card-item">
                        <span class="info-card-label">Nombre:</span>
                        <span class="info-card-value">{{ $receta->rec_nom }}</span>
                    </div>
                </div>

                <div class="inventory-card">
                    <div class="inventory-header">
                        <div class="inventory-title">Ingredientes de la Receta</div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>Ingrediente</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->ing_nom }}</td>
                                        <td>{{ $detalle->dre_can }}</td>
                                        <td>{{ $detalle->ing_um }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No hay ingredientes para esta receta.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
