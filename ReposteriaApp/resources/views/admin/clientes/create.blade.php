<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente - Repostería</title>
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
                    <div class="header-title">Crear Nuevo Cliente</div>
                    <div class="header-subtitle">Ingrese los datos del nuevo cliente</div>
                </div>
            </div>
            
            <!-- Create Client Form -->
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.clientes.store') }}" method="POST">
                        @csrf
                        @if (isset($from))
                            <input type="hidden" name="from" value="{{ $from }}">
                        @endif
                        <div class="form-group">
                            <label for="cli_cedula" class="form-label">Cédula</label>
                            <input type="text" name="cli_cedula" id="cli_cedula" class="form-input" required value="{{ old('cli_cedula', $cedula ?? '') }}">
                            @error('cli_cedula')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cli_nom" class="form-label">Nombre</label>
                            <input type="text" name="cli_nom" id="cli_nom" class="form-input" required value="{{ old('cli_nom') }}">
                            @error('cli_nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cli_apellido" class="form-label">Apellido</label>
                            <input type="text" name="cli_apellido" id="cli_apellido" class="form-input" required value="{{ old('cli_apellido') }}">
                            @error('cli_apellido')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cli_tel" class="form-label">Teléfono</label>
                            <input type="text" name="cli_tel" id="cli_tel" class="form-input" required value="{{ old('cli_tel') }}">
                            @error('cli_tel')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cli_dir" class="form-label">Dirección</label>
                            <input type="text" name="cli_dir" id="cli_dir" class="form-input" value="{{ old('cli_dir') }}">
                            @error('cli_dir')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Guardar</button>
                            <a href="{{ route('admin.clientes.index') }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
