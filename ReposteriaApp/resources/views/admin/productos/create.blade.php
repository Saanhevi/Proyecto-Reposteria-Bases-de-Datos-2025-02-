<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/BotonStyle.css') }}">
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <div class="main-content">
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Crear producto</div>
                    <div class="header-subtitle">Define la receta base y sus presentaciones</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.productos.index') }}" class="cancel-button">Volver</a>
                </div>
            </div>

            <div class="dashboard-content">
                @if (session('error'))
                    <div class="alert error">{{ session('error') }}</div>
                @endif
                @if ($errors->any() && !$errors->has('store'))
                    <div class="alert error">Revisa los campos marcados en rojo.</div>
                @endif

                <div class="inventory-card">
                    <div class="inventory-header">
                        <div>
                            <div class="inventory-title">Información del producto</div>
                            <div class="inventory-subtitle">La receta base se escala con el factor del tamaño.</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.productos.store') }}" method="POST">
                        @csrf
                        <div class="form-grid two-columns">
                            <div class="form-group">
                                <label for="pro_nom" class="form-label">Nombre del producto</label>
                                <input type="text" name="pro_nom" id="pro_nom" class="form-input" value="{{ old('pro_nom') }}" required>
                                @error('pro_nom')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rec_id" class="form-label">Receta base</label>
                                <select name="rec_id" id="rec_id" class="form-input" required>
                                    <option value="">Selecciona una receta</option>
                                    @foreach ($recetas as $receta)
                                        <option value="{{ $receta->rec_id }}" {{ old('rec_id') == $receta->rec_id ? 'selected' : '' }}>
                                            {{ $receta->rec_nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="hint">Puedes registrar nuevas recetas desde el módulo de Recetas.</p>
                                @error('rec_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="presentations-header">
                            <div>
                                <div class="inventory-title">Presentaciones y precios</div>
                                <div class="inventory-subtitle">Activa los tamaños que tendrá el producto y define su precio.</div>
                            </div>
                            @error('presentaciones')
                                <p class="error-message" style="margin: 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="presentations-grid">
                            @foreach ($tamanos as $tamano)
                                @php
                                    $isSelected = old("presentaciones.{$tamano->tam_id}.tam_id");
                                @endphp
                                <div class="presentation-card">
                                    <div class="presentation-header">
                                        <label class="toggle">
                                            <input
                                                type="checkbox"
                                                name="presentaciones[{{ $tamano->tam_id }}][tam_id]"
                                                value="{{ $tamano->tam_id }}"
                                                data-price-toggle="price-{{ $tamano->tam_id }}"
                                                {{ $isSelected ? 'checked' : '' }}
                                            >
                                            <span>{{ $tamano->tam_nom }}</span>
                                        </label>
                                        <div class="chips">
                                            <span class="chip">{{ $tamano->tam_porciones }} porciones</span>
                                            <span class="chip">Factor {{ $tamano->tam_factor }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="price-{{ $tamano->tam_id }}" class="form-label">Precio</label>
                                        <input
                                            type="number"
                                            name="presentaciones[{{ $tamano->tam_id }}][precio]"
                                            id="price-{{ $tamano->tam_id }}"
                                            class="form-input"
                                            step="0.01"
                                            min="0"
                                            value="{{ old("presentaciones.{$tamano->tam_id}.precio") }}"
                                            {{ $isSelected ? '' : 'disabled' }}
                                        >
                                        @error("presentaciones.{$tamano->tam_id}.precio")
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="primary-action-button">Crear producto</button>
                            <a href="{{ route('admin.productos.index') }}" class="cancel-button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .alert { padding: 12px 14px; border-radius: 8px; margin-bottom: 14px; border: 1px solid transparent; }
        .alert.error { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        .hint { font-size: 12px; color: #6b7280; margin-top: 6px; }
        .inventory-subtitle { color: #6b7280; font-size: 14px; }
        .form-grid.two-columns { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; }
        .presentations-header { display: flex; justify-content: space-between; align-items: center; margin: 18px 0 8px; gap: 12px; }
        .presentations-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px; }
        .presentation-card { border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; background: #ffffff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03); }
        .presentation-header { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .toggle { display: flex; align-items: center; gap: 10px; font-weight: 600; }
        .chips { display: flex; gap: 8px; flex-wrap: wrap; }
        .chip { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 999px; background: #f3f4f6; color: #374151; font-size: 12px; font-weight: 600; }
    </style>

    <script>
        document.querySelectorAll('[data-price-toggle]').forEach((checkbox) => {
            const targetId = checkbox.dataset.priceToggle;
            const priceInput = document.getElementById(targetId);

            const syncState = () => {
                if (!priceInput) return;
                const enabled = checkbox.checked;
                priceInput.disabled = !enabled;
                priceInput.required = enabled;
                if (!enabled) priceInput.value = '';
            };

            checkbox.addEventListener('change', syncState);
            syncState();
        });
    </script>
</body>
</html>
