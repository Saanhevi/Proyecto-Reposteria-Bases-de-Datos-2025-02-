<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Repostería</title>
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
                    <div class="header-title">Editar Producto</div>
                    <div class="header-subtitle">Actualice los datos del producto</div>
                </div>
                <div class="header-actions">
                </div>
            </div>
            
            <!-- Edit Product Form -->
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.productos.update', $presentacion->prp_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="pro_id" class="form-label">ID Producto</label>
                            <select name="pro_id" id="pro_id" class="form-input" required>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->pro_id }}" {{ old('pro_id', $presentacion->pro_id) == $producto->pro_id ? 'selected' : '' }}>
                                        {{ $producto->pro_nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pro_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pro_nom" class="form-label">Nombre del Producto</label>
                            <input type="text" name="pro_nom" id="pro_nom" class="form-input" value="{{ old('pro_nom', $presentacion->producto->pro_nom) }}" required>
                            @error('pro_nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tam_id" class="form-label">Tamaño</label>
                            <select name="tam_id" id="tam_id" class="form-input" required>
                                @foreach ($tamanos as $tamano)
                                    <option value="{{ $tamano->tam_id }}" {{ old('tam_id', $presentacion->tam_id) == $tamano->tam_id ? 'selected' : '' }}>
                                        {{ $tamano->tam_nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tam_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prp_precio" class="form-label">Precio</label>
                            <input type="number" name="prp_precio" id="prp_precio" class="form-input" step="0.01" value="{{ old('prp_precio', $presentacion->prp_precio) }}" required>
                            @error('prp_precio')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Actualizar</button>
                            <a href="{{ route('admin.productos.index') }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
