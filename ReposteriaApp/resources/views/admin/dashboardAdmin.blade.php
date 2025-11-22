<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
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
                <div class="nav-item active">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" fill="#1F2937"/>
                            </svg>
                        </div>
                        <div class="nav-text">Dashboard</div>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4C14.21 4 16 5.79 16 8C16 10.21 14.21 12 12 12C9.79 12 8 10.21 8 8C8 5.79 9.79 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Cliente</div>
                    </a>
                </div>
                <div class="nav-item">
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
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0L0 3V7C0 11.2 3.2 14.7 7 16C10.8 14.7 14 11.2 14 7V3L7 0ZM12 7C12 10.1 9.9 12.9 7 14C4.1 12.9 2 10.1 2 7V4.3L7 2.2L12 4.3V7Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Recetas</div>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 0H2C0.89 0 0 0.89 0 2V14C0 15.11 0.89 16 2 16H16C17.11 16 18 15.11 18 14V2C18 0.89 17.11 0 16 0ZM16 14H2V2H16V14ZM4 10H6V12H4V10ZM4 7H6V9H4V7ZM4 4H6V6H4V4ZM8 10H14V12H8V10ZM8 7H14V9H8V7ZM8 4H14V6H8V4Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Compras</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.empleados.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.empleados.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 11C17.66 11 19 9.66 19 8C19 6.34 17.66 5 16 5C14.34 5 13 6.34 13 8C13 9.66 14.34 11 16 11ZM8 11C9.66 11 11 9.66 11 8C11 6.34 9.66 5 8 5C6.34 5 5 6.34 5 8C5 9.66 6.34 11 8 11ZM8 13C5.33 13 0 14.34 0 17V20H16V17C16 14.34 10.67 13 8 13ZM16 13C15.78 13 15.56 13.01 15.34 13.02C17.07 13.57 20 14.34 20 17V20H24V17C24 14.34 18.67 13 16 13Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Empleados</div>
                    </a>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.pedidos.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.pedidos.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H10C11.1 16 12 15.1 12 14V2C12 0.9 11.1 0 10 0ZM10 14H2V2H10V14ZM4 10H6V12H4V10ZM4 7H6V9H4V7ZM4 4H6V6H4V4ZM8 10H10V12H8V10ZM8 7H10V9H8V7ZM8 4H10V6H8V4Z" fill="#4B5563"/>
                            </svg>
                        </div>
                        <div class="nav-text">Pedidos</div>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0V2H18V0H0ZM0 7H18V5H0V7ZM0 12H18V10H0V12Z" fill="#4B5563"/>
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
                    <div class="header-title">Dashboard Administrativo</div>
                    <div class="header-subtitle">Resumen general de la repostería</div>
                </div>
                <div class="header-actions">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Stats Cards -->
                <div class="stats-grid stats-grid-4-cols">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Ventas Hoy</div>
                            <div class="stat-value">Datos de BD</div>
                            <div class="stat-change positive">+12% vs ayer</div>
                        </div>
                        <div class="stat-icon sales">
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 0L0 5H2V16H8V5H10L5 0Z" fill="#16A34A"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Pedidos Activos</div>
                            <div class="stat-value">Datos de BD</div>
                            <div class="stat-change neutral">5 pendientes</div>
                        </div>
                        <div class="stat-icon orders">
                            <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H10C11.1 16 12 15.1 12 14V2C12 0.9 11.1 0 10 0ZM10 14H2V2H10V14ZM4 10H6V12H4V10ZM4 7H6V9H4V7ZM4 4H6V6H4V4ZM8 10H10V12H8V10ZM8 7H10V9H8V7ZM8 4H10V6H8V4Z" fill="#2563EB"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Productos</div>
                            <div class="stat-value">Datos de BD</div>
                            <div class="stat-change warning">8 bajo stock</div>
                        </div>
                        <div class="stat-icon products">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 4H10V0H6V4H2L0 6V14C0 14.5304 0.210714 15.0391 0.585786 15.4142C0.960859 15.7893 1.46957 16 2 16H14C14.5304 16 15.0391 15.7893 15.4142 15.4142C15.7893 15.0391 16 14.5304 16 14V6L14 4ZM8 2H8.8L9.2 4H8V2ZM2 6H14V14H2V6Z" fill="#EA580C"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Empleados</div>
                            <div class="stat-value">Datos de BD</div>
                            <div class="stat-change info">3 cajeros, 4 reposteros</div>
                        </div>
                        <div class="stat-icon employees">
                            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 4C16 2.89 16.89 2 18 2C19.11 2 20 2.89 20 4C20 5.11 19.11 6 18 6C16.89 6 16 5.11 16 4ZM10 6C10 4.89 10.89 4 12 4C13.11 4 14 4.89 14 6C14 7.11 13.11 8 12 8C10.89 8 10 7.11 10 6ZM6 6C6 4.89 6.89 4 8 4C9.11 4 10 4.89 10 6C10 7.11 9.11 8 8 8C6.89 8 6 7.11 6 6ZM0 4C0 2.89 0.89 2 2 2C3.11 2 4 2.89 4 4C4 5.11 3.11 6 2 6C0.89 6 0 5.11 0 4Z" fill="#9333EA"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Section -->
                <div class="charts-grid">
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">Ventas por Mes</div>
                            <div class="chart-filter">
                                <span>2025</span>
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 5L0 0H8L4 5Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="chart-container">
                            <div class="placeholder-chart">
                                <p>Gráfico de ventas mensuales</p>
                                <p class="placeholder-note">(Datos provenientes de la base de datos)</p>
                            </div>
                        </div>
                    </div>
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">Productos Más Vendidos</div>
                            <div class="chart-filter">
                                <span>Esta semana</span>
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 5L0 0H8L4 5Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="chart-container">
                            <div class="placeholder-chart">
                                <p>Gráfico de productos más vendidos</p>
                                <p class="placeholder-note">(Datos provenientes de la base de datos)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Inventory Section -->
                <div class="inventory-card">
                    <div class="inventory-header">
                        <div class="inventory-title">Estado del Inventario</div>
                        <div class="inventory-actions">
                            <div class="search-bar inventory-search">
                                <input type="text" placeholder="Buscar ingrediente..." class="search-input">
                            </div>
                            <button class="filter-button">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 12V8H8V12H10V6H12L7 1L2 6H4V12H6Z" fill="#1F2937"/>
                                </svg>
                                <span>Filtrar</span>
                            </button>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>Ingrediente</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Mínimo</th>
                                    <th>Proveedor</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Harina de Trigo</td>
                                    <td>Datos de BD</td>
                                    <td>Datos de BD</td>
                                    <td>Molinos del Norte</td>
                                    <td><span class="status-badge sufficient">Suficiente</span></td>
                                </tr>
                                <tr>
                                    <td>Azúcar Refinada</td>
                                    <td>Datos de BD</td>
                                    <td>Datos de BD</td>
                                    <td>Dulces SA</td>
                                    <td><span class="status-badge low">Bajo Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Mantequilla</td>
                                    <td>Datos de BD</td>
                                    <td>Datos de BD</td>
                                    <td>Lácteos Premium</td>
                                    <td><span class="status-badge sufficient">Suficiente</span></td>
                                </tr>
                                <tr>
                                    <td>Chocolate</td>
                                    <td>Datos de BD</td>
                                    <td>Datos de BD</td>
                                    <td>Cacao Premium</td>
                                    <td><span class="status-badge low">Bajo Stock</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Recent Orders Section -->
                <div class="orders-card">
                    <div class="orders-header">
                        <div class="orders-title">Pedidos Recientes</div>
                        <div class="orders-actions">
                            <div class="filter-select">
                                <span>Todos los estados</span>
                                <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 7L0 0H12L6 7Z" fill="black"/>
                                </svg>
                            </div>
                            <div class="date-selector">
                                <span>mm/dd/yyyy</span>
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="3" width="14" height="13" rx="1" stroke="black" stroke-width="1.5"/>
                                    <path d="M2 6H16" stroke="black" stroke-width="1.5"/>
                                    <path d="M5 1V3" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M13 1V3" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>ID Pedido</th>
                                    <th>Cliente</th>
                                    <th>Productos</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Datos de BD</td>
                                    <td>Ana García</td>
                                    <td>Torta Chocolate (M), Cupcakes x6</td>
                                    <td>Datos de BD</td>
                                    <td><span class="status-badge preparing">En preparación</span></td>
                                    <td>Datos de BD</td>
                                </tr>
                                <tr>
                                    <td>Datos de BD</td>
                                    <td>Carlos López</td>
                                    <td>Cheesecake (L)</td>
                                    <td>Datos de BD</td>
                                    <td><span class="status-badge completed">Completado</span></td>
                                    <td>Datos de BD</td>
                                </tr>
                                <tr>
                                    <td>Datos de BD</td>
                                    <td>María Rodríguez</td>
                                    <td>Muffins x12, Galletas x24</td>
                                    <td>Datos de BD</td>
                                    <td><span class="status-badge pending">Pendiente</span></td>
                                    <td>Datos de BD</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
