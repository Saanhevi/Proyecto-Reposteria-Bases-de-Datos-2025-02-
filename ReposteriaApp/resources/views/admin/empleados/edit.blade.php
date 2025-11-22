<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/BotonStyle.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <div class="logo-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L13.09 8.26L20 9.27L15 14.14L16.18 21.02L12 17.77L7.82 21.02L9 14.14L4 9.27L10.91 8.26L12 2Z" fill="#1F2937"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <div>reposteria</div>
                    <div class="logo-subtitle">Panel Administrador</div>
                </div>
            </div>
            <div class="nav">
                <div class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" fill="#1F2937"/>
                            </svg>
                        </div>
                        <div class="nav-text">Dashboard</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4C14.21 4 16 5.79 16 8C16 10.21 14.21 12 12 12C9.79 12 8 10.21 8 8C8 5.79 9.79 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Cliente</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.proveedores.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.proveedores.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 8H16V4H8V8H4L0 12V20H24V12L20 8ZM6 6H10V10H6V6ZM14 6H18V10H14V6Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Proveedores</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.productos.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 4H10V0H6V4H2L0 6V14C0 14.5304 0.210714 15.0391 0.585786 15.4142C0.960859 15.7893 1.46957 16 2 16H14C14.5304 16 15.0391 15.7893 15.4142 15.4142C15.7893 15.0391 16 14.5304 16 14V6L14 4ZM8 2H8.8L9.2 4H8V2ZM2 6H14V14H2V6Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Productos</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.recetas.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0L0 3V7C0 11.2 3.2 14.7 7 16C10.8 14.7 14 11.2 14 7V3L7 0ZM12 7C12 10.1 9.9 12.9 7 14C4.1 12.9 2 10.1 2 7V4.3L7 2.2L12 4.3V7Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Recetas</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.compras.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 0H2C0.89 0 0 0.89 0 2V14C0 15.11 0.89 16 2 16H16C17.11 16 18 15.11 18 14V2C18 0.89 17.11 0 16 0ZM16 14H2V2H16V14ZM4 10H6V12H4V10ZM4 7H6V9H4V7ZM4 4H6V6H4V4ZM8 10H14V12H8V10ZM8 7H14V9H8V7ZM8 4H14V6H8V4Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Compras</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.empleados.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.empleados.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 11C17.66 11 19 9.66 19 8C19 6.34 17.66 5 16 5C14.34 5 13 6.34 13 8C13 9.66 14.34 11 16 11ZM8 11C9.66 11 11 9.66 11 8C11 6.34 9.66 5 8 5C6.34 5 5 6.34 5 8C5 9.66 6.34 11 8 11ZM8 13C5.33 13 0 14.34 0 17V20H16V17C16 14.34 10.67 13 8 13ZM16 13C15.78 13 15.56 13.01 15.34 13.02C17.07 13.57 20 14.34 20 17V20H24V17C24 14.34 18.67 13 16 13Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Empleados</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V8H20V18ZM10 10H14V12H10V10ZM10 14H14V16H10V14Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Pedidos</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.pagos.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V8H20V18ZM10 10H14V12H10V10ZM10 14H14V16H10V14Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Pagos</div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Editar Empleado</div>
                    <div class="header-subtitle">Actualice los datos del empleado</div>
                </div>
                <div class="header-actions">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
            
            <!-- Edit Empleado Form -->
            <div class="main-content-form">
                <div class="form-container">
                    <form action="{{ route('admin.empleados.update', $empleado->emp_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="emp_id" class="form-label">ID Empleado</label>
                            <input type="text" name="emp_id" id="emp_id" class="form-input" value="{{ old('emp_id', $empleado->emp_id) }}" required>
                            @error('emp_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emp_nom" class="form-label">Nombre</label>
                            <input type="text" name="emp_nom" id="emp_nom" class="form-input" value="{{ old('emp_nom', $empleado->emp_nom) }}" required>
                            @error('emp_nom')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emp_tel" class="form-label">Teléfono</label>
                            <input type="text" name="emp_tel" id="emp_tel" class="form-input" value="{{ old('emp_tel', $empleado->emp_tel) }}" required>
                            @error('emp_tel')
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
