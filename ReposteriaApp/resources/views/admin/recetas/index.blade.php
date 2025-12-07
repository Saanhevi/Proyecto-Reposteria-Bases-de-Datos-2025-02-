<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas - Administrador</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/BotonStyle.css') }}">
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <div class="main-content">
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Gestión de Recetas</div>
                    <div class="header-subtitle">Administra las recetas y sus ingredientes</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.recetas.create') }}" class="primary-action-button">Crear Receta</a>
                </div>
            </div>

            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-container">
                <table class="inventory-table" id="recetas-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recetas as $receta)
                            <tr>
                                <td>{{ $receta->rec_id }}</td>
                                <td>{{ $receta->rec_nom }}</td>
                                <td class="actions">
                                                                        <a href="{{ route('admin.recetas.show', $receta) }}" class="action-button">Ver</a>
                                                                            <a href="{{ route('admin.recetas.edit', $receta) }}" class="action-button edit-button">Editar</a>
                                                                            <form action="{{ route('admin.recetas.destroy', $receta) }}" method="POST" style="display:inline-block;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="action-button delete-button" onclick="return confirm('¿Estás seguro de que quieres eliminar esta receta?')">Eliminar</button>
                                                                            </form>                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">No hay recetas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination-container">
                    {{ $recetas->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        (function(){
            const input = document.getElementById('receta-filter');
            const rows = Array.from(document.querySelectorAll('#recetas-table tbody tr'));
            if (!input) return;
            input.addEventListener('input', () => {
                const q = input.value.toLowerCase();
                rows.forEach(r => {
                    r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
                });
            });
        })();
    </script>
</body>
</html>
