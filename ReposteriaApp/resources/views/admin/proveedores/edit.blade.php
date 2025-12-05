<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor - Repostería</title>
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
                    <div class="header-title">Editar Proveedor</div>
                    <div class="header-subtitle">Actualice los datos del proveedor</div>
                </div>
            </div>
            
            <!-- Edit Proveedor Form -->
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.proveedores.update', $proveedor->prov_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="prov_id" class="form-label">ID</label>
                            <input type="text" name="prov_id" id="prov_id" class="form-input" value="{{ $proveedor->prov_id }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="prov_nom" class="form-label">Nombre</label>
                            <input type="text" name="prov_nom" id="prov_nom" class="form-input" value="{{ old('prov_nom', $proveedor->prov_nom) }}" required>
                            @error('prov_nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prov_tel" class="form-label">Teléfono</label>
                            <input type="text" name="prov_tel" id="prov_tel" class="form-input" value="{{ old('prov_tel', $proveedor->prov_tel) }}" required>
                            @error('prov_tel')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prov_dir" class="form-label">Dirección</label>
                            <input type="text" name="prov_dir" id="prov_dir" class="form-input" required value="{{ old('prov_dir', $proveedor->prov_dir) }}">
                            @error('prov_dir')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Actualizar</button>
                            <a href="{{ route('admin.proveedores.index') }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>