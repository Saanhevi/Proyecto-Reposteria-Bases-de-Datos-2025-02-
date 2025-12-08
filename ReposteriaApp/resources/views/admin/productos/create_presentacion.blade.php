<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Presentación - {{ $producto->pro_nom }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/BotonStyle.css') }}">
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <div class="main-content">
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Agregar presentación a {{ $producto->pro_nom }}</div>
                    <div class="header-subtitle">Receta base: {{ $producto->receta->rec_nom ?? 'Sin receta asignada' }}</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.productos.showPresentaciones', $producto->pro_id) }}" class="cancel-button">Volver</a>
                </div>
            </div>

            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.productos.storePresentacion', $producto->pro_id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tam_id" class="form-label">Tamaño</label>
                            <select name="tam_id" id="tam_id" class="form-input" required>
                                <option value="">Seleccione un tamaño</option>
                                @foreach ($tamanos as $tamano)
                                    <option value="{{ $tamano->tam_id }}" {{ old('tam_id') == $tamano->tam_id ? 'selected' : '' }}>
                                        {{ $tamano->tam_nom }} — {{ $tamano->tam_porciones }} porciones (factor {{ $tamano->tam_factor }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tam_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prp_precio" class="form-label">Precio</label>
                            <input type="number" name="prp_precio" id="prp_precio" class="form-input" step="0.01" min="0" required value="{{ old('prp_precio') }}">
                            <p class="hint">El costo de insumos se ajusta con el factor del tamaño.</p>
                            @error('prp_precio')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Guardar presentación</button>
                            <a href="{{ route('admin.productos.showPresentaciones', $producto->pro_id) }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hint { font-size: 12px; color: #6b7280; margin-top: 6px; }
    </style>
</body>
</html>
