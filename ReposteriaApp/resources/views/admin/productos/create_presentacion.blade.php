<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Presentación a {{ $producto->pro_nom }} - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
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
                    <div class="header-title">Agregar Presentación a {{ $producto->pro_nom }}</div>
                    <div class="header-subtitle">Ingrese los datos de la nueva presentación</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.productos.showPresentaciones', $producto->pro_id) }}" class="cancel-button">Volver a Presentaciones</a>
                </div>
            </div>
            
            <!-- Create Presentation Form -->
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
                                        {{ $tamano->tam_nom }} ({{ $tamano->tam_porciones }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tam_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prp_precio" class="form-label">Precio</label>
                            <input type="number" name="prp_precio" id="prp_precio" class="form-input" step="0.01" required value="{{ old('prp_precio') }}">
                            @error('prp_precio')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Guardar Presentación</button>
                            <a href="{{ route('admin.productos.showPresentaciones', $producto->pro_id) }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
