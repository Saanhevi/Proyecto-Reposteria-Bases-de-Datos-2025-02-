<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Presentación - {{ $presentacion->producto->pro_nom }}</title>
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
                    <div class="header-title">Editar presentación</div>
                    <div class="header-subtitle">Ajusta los datos del producto y su precio</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.productos.showPresentaciones', $presentacion->pro_id) }}" class="cancel-button">Volver</a>
                </div>
            </div>
            
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.productos.update', $presentacion->prp_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-grid two-columns">
                            <div class="form-group">
                                <label for="pro_nom" class="form-label">Nombre del producto</label>
                                <input type="text" name="pro_nom" id="pro_nom" class="form-input" value="{{ old('pro_nom', $presentacion->producto->pro_nom) }}" required>
                                @error('pro_nom')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rec_id" class="form-label">Receta base</label>
                                <select name="rec_id" id="rec_id" class="form-input" required>
                                    @foreach ($recetas as $receta)
                                        <option value="{{ $receta->rec_id }}" {{ old('rec_id', $presentacion->producto->receta?->rec_id ?? null) == $receta->rec_id ? 'selected' : '' }}>
                                            {{ $receta->rec_nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="hint">La receta se escala según el factor del tamaño.</p>
                                @error('rec_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid two-columns">
                            <div class="form-group">
                                <label class="form-label">Tamaño</label>
                                <input type="text" class="form-input" value="{{ $presentacion->tamano->tam_nom }} — {{ $presentacion->tamano->tam_porciones }} porciones (factor {{ $presentacion->tamano->tam_factor }})" disabled>
                            </div>
                            <div class="form-group">
                                <label for="prp_precio" class="form-label">Precio</label>
                                <input type="number" name="prp_precio" id="prp_precio" class="form-input" step="0.01" min="0" value="{{ old('prp_precio', $presentacion->prp_precio) }}" required>
                                @error('prp_precio')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Actualizar</button>
                            <a href="{{ route('admin.productos.showPresentaciones', $presentacion->pro_id) }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-grid.two-columns { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; }
        .hint { font-size: 12px; color: #6b7280; margin-top: 6px; }
    </style>
</body>
</html>
