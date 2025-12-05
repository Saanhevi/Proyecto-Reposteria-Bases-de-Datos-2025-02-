<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cajero - Repostería</title>
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
                    <div class="header-title">Editar Cajero</div>
                    <div class="header-subtitle">Actualice los datos del cajero</div>
                </div>
                <div class="header-actions">
                </div>
            </div>
            
            <!-- Edit Cajero Form -->
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.cajeros.update', $cajero->emp_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="emp_nom" class="form-label">Nombre</label>
                            <input type="text" name="emp_nom" id="emp_nom" class="form-input" value="{{ old('emp_nom', $cajero->empleado->emp_nom) }}" required>
                            @error('emp_nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emp_tel" class="form-label">Teléfono</label>
                            <input type="text" name="emp_tel" id="emp_tel" class="form-input" value="{{ old('emp_tel', $cajero->empleado->emp_tel) }}" required>
                            @error('emp_tel')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="caj_turno" class="form-label">Turno</label>
                            <select name="caj_turno" id="caj_turno" class="form-input" required>
                                <option value="">Seleccione un turno</option>
                                <option value="Mañana" {{ old('caj_turno', $cajero->caj_turno) == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                                <option value="Tarde" {{ old('caj_turno', $cajero->caj_turno) == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="Noche" {{ old('caj_turno', $cajero->caj_turno) == 'Noche' ? 'selected' : '' }}>Noche</option>
                            </select>
                            @error('caj_turno')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Actualizar</button>
                            <a href="{{ route('admin.empleados.index') }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
