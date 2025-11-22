<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cajero</title>
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
                    <div class="logo-subtitle">CAJERO</div>
                </div>
            </div>
            <div class="nav">
                <div class="nav-item">
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
                    <div class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 4H10V0H6V4H2L0 6V14C0 14.5304 0.210714 15.0391 0.585786 15.4142C0.960859 15.7893 1.46957 16 2 16H14C14.5304 16 15.0391 15.7893 15.4142 15.4142C15.7893 15.0391 16 14.5304 16 14V6L14 4ZM8 2H8.8L9.2 4H8V2ZM2 6H14V14H2V6Z" fill="#4B5563"/>
                        </svg>
                    </div>
                    <div class="nav-text">Productos</div>
                </div>
                <div class="nav-item">
                    <div class="nav-icon">
                        <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H10C11.1 16 12 15.1 12 14V2C12 0.9 11.1 0 10 0ZM10 14H2V2H10V14ZM4 10H6V12H4V10ZM4 7H6V9H4V7ZM4 4H6V6H4V4ZM8 10H10V12H8V10ZM8 7H10V9H8V7ZM8 4H10V6H8V4Z" fill="#4B5563"/>
                        </svg>
                    </div>
                    <div class="nav-text">Pedidos</div>
                </div>
                <div class="nav-item">
                    <div class="nav-icon">
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0V2H18V0H0ZM0 7H18V5H0V7ZM0 12H18V10H0V12Z" fill="#4B5563"/>
                        </svg>
                    </div>
                    <div class="nav-text">Pagos</div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Dashboard Cajero</div>
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
                <div class="stats-grid stats-grid-3-cols">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Dinero en caja</div>
                            <div class="stat-value">Datos de BD</div>
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
                </div>
                
                <!-- Charts Section -->
                <div class="charts-grid">
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
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">Estado Pedidos</div>
                        </div>
                        <div class="table-container">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Datos de BD</td>
                                        <td><span class="status-badge preparing">En preparación</span></td>
                                        <td>Datos de BD</td>
                                    </tr>
                                    <tr>
                                        <td>Datos de BD</td>
                                        <td><span class="status-badge completed">Completado</span></td>
                                        <td>Datos de BD</td>
                                    </tr>
                                    <tr>
                                        <td>Datos de BD</td>
                                        <td><span class="status-badge pending">Pendiente</span></td>
                                        <td>Datos de BD</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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