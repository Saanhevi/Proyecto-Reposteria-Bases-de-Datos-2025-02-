<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receta - Repostería</title>
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
                    <div class="header-title">Editar Receta</div>
                    <div class="header-subtitle">Modifica el formulario para actualizar la receta.</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.recetas.index') }}" class="cancel-button">Cancelar</a>
                </div>
            </div>

            <div class="form-container">
                <form action="{{ route('admin.recetas.update', $receta) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="rec_nom" class="form-label">Nombre de la Receta</label>
                        <input type="text" name="rec_nom" id="rec_nom" class="form-input" value="{{ old('rec_nom', $receta->rec_nom) }}" required>
                    </div>

                    <h3 class="summary-title">Ingredientes</h3>
                    <div id="ingredientes-container">
                        @foreach ($detalles as $detalle)
                            <div class="form-group ingredient-group">
                                <select name="ingredientes[{{ $loop->index }}][id]" class="form-input" required>
                                    @foreach ($ingredientes as $ingrediente)
                                        <option value="{{ $ingrediente->ing_id }}" @if($ingrediente->ing_id == $detalle->ing_id) selected @endif>{{ $ingrediente->ing_nom }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="ingredientes[{{ $loop->index }}][cantidad]" class="form-input" placeholder="Cantidad" step="0.01" value="{{ $detalle->dre_can }}" required>
                                <button type="button" class="danger-button remove-ingrediente">Eliminar</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-actions">
                        <button type="button" id="add-ingrediente" class="secondary-action-button">Añadir Ingrediente</button>
                        <button type="submit" class="primary-action-button">Actualizar Receta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ingredientesContainer = document.getElementById('ingredientes-container');
            const addIngredienteBtn = document.getElementById('add-ingrediente');
            let ingredienteIndex = {{ $detalles->count() }};

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
