<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empleado - Repostería</title>
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
                    <div class="header-title">Crear Nuevo Empleado</div>
                    <div class="header-subtitle">Ingrese los datos del nuevo empleado</div>
                </div>
                <div class="header-actions">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
            
            <!-- Create Empleado Form -->
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.empleados.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="emp_id" class="form-label">ID Empleado</label>
                            <input type="text" name="emp_id" id="emp_id" class="form-input" required value="{{ old('emp_id') }}">
                            @error('emp_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emp_nom" class="form-label">Nombre</label>
                            <input type="text" name="emp_nom" id="emp_nom" class="form-input" required value="{{ old('emp_nom') }}">
                            @error('emp_nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emp_tel" class="form-label">Teléfono</label>
                            <input type="text" name="emp_tel" id="emp_tel" class="form-input" required value="{{ old('emp_tel') }}">
                            @error('emp_tel')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Guardar</button>
                            <a href="{{ route('admin.empleados.index') }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
