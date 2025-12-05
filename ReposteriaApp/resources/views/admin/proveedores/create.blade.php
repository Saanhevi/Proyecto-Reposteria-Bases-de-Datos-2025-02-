<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proveedor - Repostería</title>
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
                    <div class="header-title">Crear Nuevo Proveedor</div>
                    <div class="header-subtitle">Ingrese los datos del nuevo proveedor</div>
                </div>
            </div>
            
            <!-- Create Proveedor Form -->
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.proveedores.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="prov_nom" class="form-label">Nombre</label>
                            <input type="text" name="prov_nom" id="prov_nom" class="form-input" required value="{{ old('prov_nom') }}">
                            @error('prov_nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prov_tel" class="form-label">Teléfono</label>
                            <input type="text" name="prov_tel" id="prov_tel" class="form-input" required value="{{ old('prov_tel') }}">
                            @error('prov_tel')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prov_dir" class="form-label">Dirección</label>
                            <input type="text" name="prov_dir" id="prov_dir" class="form-input" required value="{{ old('prov_dir') }}">
                            @error('direccion')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Guardar</button>
                            <a href="{{ route('admin.proveedores.index') }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>