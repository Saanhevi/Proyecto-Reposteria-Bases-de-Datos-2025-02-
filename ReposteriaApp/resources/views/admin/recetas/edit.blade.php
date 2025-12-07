<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receta - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/createRecetaStyles.css') }}">
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

            <div class="form-container" style="max-width: 900px; margin: 24px auto;">
                <form action="{{ route('admin.recetas.update', $receta) }}" method="POST" id="edit-receta-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="rec_nom" class="form-label">Nombre de la Receta</label>
                        <input type="text" name="rec_nom" id="rec_nom" class="form-input" value="{{ old('rec_nom', $receta->rec_nom) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Añadir Ingredientes</label>
                        <div class="product-adder-grid">
                            <div class="form-group">
                                <label for="ingrediente-selector" class="form-label">Ingrediente</label>
                                <select id="ingrediente-selector" class="form-input">
                                    <option value="">Seleccione un ingrediente</option>
                                    @foreach ($ingredientes as $ingrediente)
                                        <option value="{{ $ingrediente->ing_id }}" data-um="{{ $ingrediente->ing_um }}">{{ $ingrediente->ing_nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="quantity-adder">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">Cantidad</label>
                                    <input type="number" id="quantity" class="form-input" value="1" min="0.01" step="0.01">
                                </div>
                                <button type="button" id="add-ingrediente" class="secondary-action-button">Añadir</button>
                            </div>
                        </div>
                    </div>

                    <h3 class="summary-title">Ingredientes de la Receta</h3>
                    <div class="table-container" style="padding: 0;">
                        <table id="ingredient-table">
                            <thead>
                                <tr>
                                    <th>Ingrediente</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                    <th class="action-cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ingredients will be added here by JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <div id="hidden-inputs-container"></div>

                    <div class="form-actions" style="margin-top: 24px;">
                        <button type="submit" class="primary-action-button">Actualizar Receta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addIngredienteBtn = document.getElementById('add-ingrediente');
            const ingredienteSelector = document.getElementById('ingrediente-selector');
            const quantityInput = document.getElementById('quantity');
            const ingredientTableBody = document.querySelector('#ingredient-table tbody');
            const hiddenInputsContainer = document.getElementById('hidden-inputs-container');
            const form = document.getElementById('edit-receta-form');

            let recipeIngredients = @json($detalles->map(function($detalle) use ($ingredientes) {
                $ingrediente = $ingredientes->firstWhere('ing_id', $detalle->ing_id);
                return [
                    'id' => $detalle->ing_id,
                    'name' => $ingrediente ? $ingrediente->ing_nom : 'Unknown',
                    'quantity' => $detalle->dre_can,
                    'um' => $ingrediente ? $ingrediente->ing_um : 'N/A',
                ];
            })->values());

            function renderTable() {
                ingredientTableBody.innerHTML = '';
                if (recipeIngredients.length === 0) {
                    ingredientTableBody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay ingredientes en la receta.</td></tr>';
                } else {
                    recipeIngredients.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.quantity}</td>
                                <td>${item.um}</td>
                                <td class="action-cell">
                                    <button type="button" class="action-button delete-button remove-ingrediente" data-id="${item.id}">X</button>
                                </td>
                            </tr>
                        `;
                        ingredientTableBody.innerHTML += row;
                    });
                }
            }

            addIngredienteBtn.addEventListener('click', function () {
                const selectedOption = ingredienteSelector.options[ingredienteSelector.selectedIndex];
                if (!selectedOption.value) {
                    alert('Por favor, seleccione un ingrediente.');
                    return;
                }

                const ingredientId = selectedOption.value;
                const ingredientName = selectedOption.text;
                const ingredientUm = selectedOption.dataset.um;
                const quantity = parseFloat(quantityInput.value);

                if (isNaN(quantity) || quantity <= 0) {
                    alert('Por favor, ingrese una cantidad válida.');
                    return;
                }

                const existingIngredient = recipeIngredients.find(item => item.id === ingredientId);
                if (existingIngredient) {
                    existingIngredient.quantity += quantity;
                } else {
                    recipeIngredients.push({
                        id: ingredientId,
                        name: ingredientName,
                        quantity: quantity,
                        um: ingredientUm
                    });
                }

                renderTable();

                ingredienteSelector.value = '';
                quantityInput.value = '1';
            });

            ingredientTableBody.addEventListener('click', function (e) {
                if (e.target.closest('.remove-ingrediente')) {
                    const idToRemove = e.target.closest('.remove-ingrediente').dataset.id;
                    recipeIngredients = recipeIngredients.filter(item => item.id !== idToRemove);
                    renderTable();
                }
            });

            form.addEventListener('submit', function (e) {
                hiddenInputsContainer.innerHTML = '';
                if (recipeIngredients.length === 0) {
                    e.preventDefault();
                    alert('Debe añadir al menos un ingrediente a la receta.');
                    return;
                }
                recipeIngredients.forEach((item, index) => {
                    hiddenInputsContainer.innerHTML += `
                        <input type="hidden" name="ingredientes[${index}][id]" value="${item.id}">
                        <input type="hidden" name="ingredientes[${index}][cantidad]" value="${item.quantity}">
                    `;
                });
            });

            renderTable();
        });
    </script>
</body>
</html>
