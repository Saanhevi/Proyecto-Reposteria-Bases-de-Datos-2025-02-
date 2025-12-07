<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Receta - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
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
                    <a href="{{ route('admin.recetas.index') }}" class="cancel-button">Volver al Listado</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ $receta->rec_nom }}</h2>
                </div>
                <div class="card-body">
                    <h3 class="summary-title">Ingredientes</h3>
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
