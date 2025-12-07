<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Receta - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <div class="main-content">
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Crear Nueva Receta</div>
                    <div class="header-subtitle">Completa el formulario para registrar una nueva receta.</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.recetas.index') }}" class="cancel-button">Cancelar</a>
                </div>
            </div>

            <div class="form-container">
                <form action="{{ route('admin.recetas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rec_nom" class="form-label">Nombre de la Receta</label>
                        <input type="text" name="rec_nom" id="rec_nom" class="form-input" value="{{ old('rec_nom') }}" required>
                    </div>

                    <h3 class="summary-title">Ingredientes</h3>
                    <div id="ingredientes-container">
                        <!-- Ingredient inputs will be added here -->
                    </div>

                    <div class="form-actions">
                        <button type="button" id="add-ingrediente" class="secondary-action-button">Añadir Ingrediente</button>
                        <button type="submit" class="primary-action-button">Guardar Receta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ingredientesContainer = document.getElementById('ingredientes-container');
            const addIngredienteBtn = document.getElementById('add-ingrediente');
            let ingredienteIndex = 0;

            const ingredientes = @json($ingredientes);

            addIngredienteBtn.addEventListener('click', function () {
                const ingredienteDiv = document.createElement('div');
                ingredienteDiv.classList.add('form-group', 'ingredient-group');
                ingredienteDiv.innerHTML = `
                    <select name="ingredientes[${ingredienteIndex}][id]" class="form-input" required>
                        <option value="">Seleccione un ingrediente</option>
                        ${ingredientes.map(ing => `<option value="${ing->ing_id}">${ing->ing_nom}</option>`).join('')}
                    </select>
                    <input type="number" name="ingredientes[${ingredienteIndex}][cantidad]" class="form-input" placeholder="Cantidad" step="0.01" required>
                    <button type="button" class="danger-button remove-ingrediente">Eliminar</button>
                `;
                ingredientesContainer.appendChild(ingredienteDiv);
                ingredienteIndex++;
            });

            ingredientesContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-ingrediente')) {
                    e.target.closest('.ingredient-group').remove();
                }
            });
        });
    </script>
</body>
</html>
