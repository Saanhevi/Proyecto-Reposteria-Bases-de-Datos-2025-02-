<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Pedido - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/BotonStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/createPedidoStyles.css') }}">
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
                        <div class="nav-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" fill="#1F2937"/></svg></div>
                        <div class="nav-text">Dashboard</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link">
                        <div class="nav-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 4C14.21 4 16 5.79 16 8C16 10.21 14.21 12 12 12C9.79 12 8 10.21 8 8C8 5.79 9.79 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z" fill="#4B5563"/></svg></div>
                        <div class="nav-text">Cliente</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.proveedores.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.proveedores.index') }}" class="nav-link">
                        <div class="nav-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 8H16V4H8V8H4L0 12V20H24V12L20 8ZM6 6H10V10H6V6ZM14 6H18V10H14V6Z" fill="#4B5563"/></svg></div>
                        <div class="nav-text">Proveedores</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.productos.index') }}" class="nav-link">
                        <div class="nav-icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 4H10V0H6V4H2L0 6V14C0 14.5304 0.210714 15.0391 0.585786 15.4142C0.960859 15.7893 1.46957 16 2 16H14C14.5304 16 15.0391 15.7893 15.4142 15.4142C15.7893 15.0391 16 14.5304 16 14V6L14 4ZM8 2H8.8L9.2 4H8V2ZM2 6H14V14H2V6Z" fill="#4B5563"/></svg></div>
                        <div class="nav-text">Productos</div>
                    </a>
                </div>
                <div class="nav-item"><a href="#" class="nav-link"><div class="nav-icon"><svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 0L0 3V7C0 11.2 3.2 14.7 7 16C10.8 14.7 14 11.2 14 7V3L7 0ZM12 7C12 10.1 9.9 12.9 7 14C4.1 12.9 2 10.1 2 7V4.3L7 2.2L12 4.3V7Z" fill="#4B5563"/></svg></div><div class="nav-text">Recetas</div></a></div>
                <div class="nav-item"><a href="#" class="nav-link"><div class="nav-icon"><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 0H2C0.89 0 0 0.89 0 2V14C0 15.11 0.89 16 2 16H16C17.11 16 18 15.11 18 14V2C18 0.89 17.11 0 16 0ZM16 14H2V2H16V14ZM4 10H6V12H4V10ZM4 7H6V9H4V7ZM4 4H6V6H4V4ZM8 10H14V12H8V10ZM8 7H14V9H8V7ZM8 4H14V6H8V4Z" fill="#4B5563"/></svg></div><div class="nav-text">Compras</div></a></div>
                <div class="nav-item {{ request()->routeIs('admin.empleados.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.empleados.index') }}" class="nav-link">
                        <div class="nav-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 11C17.66 11 19 9.66 19 8C19 6.34 17.66 5 16 5C14.34 5 13 6.34 13 8C13 9.66 14.34 11 16 11ZM8 11C9.66 11 11 9.66 11 8C11 6.34 9.66 5 8 5C6.34 5 5 6.34 5 8C5 9.66 6.34 11 8 11ZM8 13C5.33 13 0 14.34 0 17V20H16V17C16 14.34 10.67 13 8 13ZM16 13C15.78 13 15.56 13.01 15.34 13.02C17.07 13.57 20 14.34 20 17V20H24V17C24 14.34 18.67 13 16 13Z" fill="#4B5563"/></svg></div>
                        <div class="nav-text">Empleados</div>
                    </a>
                </div>
                <div class="nav-item {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pedidos.index') }}" class="nav-link">
                        <div class="nav-icon"><svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H10C11.1 16 12 15.1 12 14V2C12 0.9 11.1 0 10 0ZM10 14H2V2H10V14ZM4 10H6V12H4V10ZM4 7H6V9H4V7ZM4 4H6V6H4V4ZM8 10H10V12H8V10ZM8 7H10V9H8V7ZM8 4H10V6H8V4Z" fill="#4B5563"/></svg></div>
                        <div class="nav-text">Pedidos</div>
                    </a>
                </div>
                <div class="nav-item"><a href="#" class="nav-link"><div class="nav-icon"><svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0V2H18V0H0ZM0 7H18V5H0V7ZM0 12H18V10H0V12Z" fill="#4B5563"/></svg></div><div class="nav-text">Pagos</div></a></div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-info">
                    <div class="header-title">Crear Nuevo Pedido</div>
                    <div class="header-subtitle">Completa el formulario para registrar un nuevo pedido.</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.pedidos.index') }}" class="cancel-button">Cancelar</a>
                </div>
            </div>
            
            <div class="form-container" style="max-width: 900px; margin: 24px auto;">
                <form action="{{ route('admin.pedidos.store') }}" method="POST" id="create-order-form"
                    data-clientes='@json($clientes)'
                    data-productos='@json($productos)'>
                    @csrf
                    <div class="form-container-grid">
                        <div class="form-group">
                            <label for="cli_cedula_input" class="form-label">Cliente</label>
                            <div class="input-group">
                                <input type="text" id="cli_cedula_input" class="form-input" placeholder="Digite la cédula del cliente" value="{{ $cli_cedula ?? '' }}">
                                <input type="hidden" name="cli_cedula" id="hidden_cli_cedula">
                                <button type="button" id="search-client" class="search-button">Buscar</button>
                            </div>
                            <div id="client-info"></div>
                        </div>
                        <div class="form-group">
                            <label for="emp_id" class="form-label">Cajero</label>
                            <select name="emp_id" id="emp_id" class="form-input" required>
                                <option value="">Seleccione un cajero</option>
                                @foreach ($cajeros as $cajero)
                                    <option value="{{ $cajero->emp_id }}">{{ $cajero->empleado->emp_nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Añadir Productos</label>
                        <div class="product-adder-grid">
                            <div class="form-group">
                                <label for="product-selector" class="form-label">Producto</label>
                                <select id="product-selector" class="form-input">
                                    <option value="">Seleccione un producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->pro_id }}">{{ $producto->pro_nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="size-selector" class="form-label">Tamaño</label>
                                <select id="size-selector" class="form-input" disabled>
                                    <option value="">Seleccione un tamaño</option>
                                </select>
                            </div>
                        </div>
                        <div class="quantity-adder">
                            <div class="form-group">
                                <label for="quantity" class="form-label">Cantidad</label>
                                <input type="number" id="quantity" class="form-input" value="1" min="1">
                            </div>
                            <button type="button" id="add-product" class="primary-action-button">Añadir</button>
                        </div>
                    </div>

                    <h3 class="summary-title">Resumen del Pedido</h3>
                    <div class="table-container" style="padding: 0;">
                        <table id="order-items-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="item-quantity">Cant.</th>
                                    <th class="item-price">P/U</th>
                                    <th class="item-subtotal">Subtotal</th>
                                    <th class="action-cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be added here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div class="summary-total">
                        <span class="total-label">Total:</span>
                        <span class="total-value" id="order-total">$0</span>
                    </div>

                    <div id="hidden-inputs-container"></div>

                    <div class="form-actions" style="margin-top: 24px;">
                        <button type="submit" class="primary-action-button">Guardar Pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Script starting.");
            const createOrderForm = document.getElementById('create-order-form');
            if (!createOrderForm) {
                console.error("Form 'create-order-form' not found.");
                return;
            }

            let clientesData = [];
            let productosData = [];

            try {
                clientesData = JSON.parse(createOrderForm.dataset.clientes || '[]');
                console.log("clientesData loaded:", clientesData);
            } catch (e) {
                console.error("Error parsing clientesData from data attribute:", e);
            }

            try {
                productosData = JSON.parse(createOrderForm.dataset.productos || '[]');
                console.log("productosData loaded:", productosData);
            } catch (e) {
                console.error("Error parsing productosData from data attribute:", e);
            }

            // Client Search Elements
            const clientSearchInput = document.getElementById('cli_cedula_input');
            const searchClientBtn = document.getElementById('search-client');
            const clientInfoDiv = document.getElementById('client-info');
            const hiddenCliCedulaInput = document.getElementById('hidden_cli_cedula');

            function findClient() {
                const cedula = clientSearchInput.value.trim();
                console.log('Searching for client with cedula:', cedula);
                if (cedula === "") {
                    clientInfoDiv.textContent = '';
                    hiddenCliCedulaInput.value = '';
                    return;
                }

                const client = clientesData.find(c => String(c.cli_cedula) === String(cedula));
                if (client) {
                    clientInfoDiv.innerHTML = `<strong>Cliente:</strong> ${client.cli_nom} ${client.cli_apellido}`;
                    clientInfoDiv.style.color = '#166534';
                    hiddenCliCedulaInput.value = client.cli_cedula;
                    console.log('Client found:', client);
                } else {
                    clientInfoDiv.textContent = 'Cliente no encontrado.';
                    clientInfoDiv.style.color = '#991B1B';
                    hiddenCliCedulaInput.value = '';
                    if (cedula.length === 10 && /^\d+$/.test(cedula)) {
                        if (confirm('Cliente no encontrado. ¿Desea registrar este nuevo cliente?')) {
                            window.location.href = `{{ route('admin.clientes.create') }}?cedula=${cedula}&from=pedidos`;
                        }
                    }
                    console.log('Client not found.');
                }
            }

            // Event Listeners for Client Search
            searchClientBtn.addEventListener('click', findClient);
            clientSearchInput.addEventListener('blur', findClient);
            if (clientSearchInput.value) { // Trigger on page load if pre-filled
                findClient();
            }

            // Product Selection Elements
            const productSelector = document.getElementById('product-selector');
            const sizeSelector = document.getElementById('size-selector');
            const quantityInput = document.getElementById('quantity');
            const addProductBtn = document.getElementById('add-product');
            const orderItemsTableBody = document.querySelector('#order-items-table tbody');
            const orderTotalCell = document.getElementById('order-total');
            const hiddenInputsContainer = document.getElementById('hidden-inputs-container');

            let orderItems = [];

            function populateSizes() {
                const selectedProductId = productSelector.value;
                sizeSelector.innerHTML = '<option value="">Seleccione un tamaño</option>';
                sizeSelector.disabled = true;

                if (selectedProductId) {
                    const selectedProduct = productosData.find(p => String(p.pro_id) === String(selectedProductId));
                    if (selectedProduct && selectedProduct.presentaciones && selectedProduct.presentaciones.length > 0) {
                        sizeSelector.disabled = false;
                        selectedProduct.presentaciones.forEach(presentacion => {
                            const option = document.createElement('option');
                            option.value = presentacion.prp_id;
                            option.textContent = `${presentacion.tamano.tam_nom} - $${presentacion.prp_precio.toLocaleString('es-CO')}`;
                            option.dataset.price = presentacion.prp_precio;
                            option.dataset.name = `${selectedProduct.pro_nom} (${presentacion.tamano.tam_nom})`;
                            sizeSelector.appendChild(option);
                        });
                        console.log('Sizes populated for product:', selectedProductId);
                    } else {
                        console.log('Selected product or its presentations not found/empty for product:', selectedProductId);
                    }
                }
            }

            // Event Listener for Product Selection
            productSelector.addEventListener('change', populateSizes);

            function addProductToOrder() {
                const selectedSizeOption = sizeSelector.options[sizeSelector.selectedIndex];
                if (!selectedSizeOption || !selectedSizeOption.value) {
                    alert('Por favor, seleccione un producto y un tamaño.');
                    console.log('Add product failed: No product or size selected.');
                    return;
                }

                const prp_id = selectedSizeOption.value;
                const name = selectedSizeOption.dataset.name;
                const price = parseFloat(selectedSizeOption.dataset.price);
                const quantity = parseInt(quantityInput.value);

                if (isNaN(quantity) || quantity < 1) {
                    alert('Por favor, introduce una cantidad válida.');
                    console.log('Add product failed: Invalid quantity:', quantity);
                    return;
                }

                const existingItemIndex = orderItems.findIndex(item => String(item.id) === String(prp_id));
                if (existingItemIndex > -1) {
                    orderItems[existingItemIndex].quantity += quantity;
                    console.log('Updated existing item:', orderItems[existingItemIndex]);
                } else {
                    orderItems.push({ id: prp_id, name: name, quantity: quantity, price: price });
                    console.log('Added new item:', { id: prp_id, name: name, quantity: quantity, price: price });
                }
                
                renderTable();
                updateTotal();
                // Reset product selection for next item
                productSelector.value = "";
                populateSizes(); // Clear sizes
                quantityInput.value = 1;
            }

            // Event Listener for Add Product Button
            addProductBtn.addEventListener('click', addProductToOrder);

            function renderTable() {
                orderItemsTableBody.innerHTML = '';
                if (orderItems.length === 0) {
                    orderItemsTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No hay productos en el pedido.</td></tr>';
                    return;
                }
                orderItems.forEach(item => {
                    const subtotal = item.quantity * item.price;
                    const row = `
                        <tr>
                            <td class="item-name">${item.name}</td>
                            <td class="item-quantity">${item.quantity}</td>
                            <td class="item-price">$${item.price.toLocaleString('es-CO')}</td>
                            <td class="item-subtotal">$${subtotal.toLocaleString('es-CO')}</td>
                            <td class="action-cell">
                                <button type="button" class="action-button delete-button remove-item" data-id="${item.id}">X</button>
                            </td>
                        </tr>
                    `;
                    orderItemsTableBody.innerHTML += row;
                });
                console.log('Order table rendered.');
            }

            function updateTotal() {
                const total = orderItems.reduce((sum, item) => sum + (item.quantity * item.price), 0);
                orderTotalCell.textContent = `$${total.toLocaleString('es-CO')}`;
                console.log('Order total updated:', total);
            }

            // Event Listener for Removing Items
            orderItemsTableBody.addEventListener('click', function (e) {
                if (e.target.closest('.delete-button')) {
                    const idToRemove = e.target.closest('.delete-button').dataset.id;
                    orderItems = orderItems.filter(item => String(item.id) !== String(idToRemove));
                    renderTable();
                    updateTotal();
                    console.log('Item removed with ID:', idToRemove);
                }
            });

            // Form Submission Handler
            createOrderForm.addEventListener('submit', function(e) {
                console.log('Form submission attempted.');
                if (!hiddenCliCedulaInput.value) {
                    e.preventDefault();
                    alert('Debes seleccionar un cliente válido.');
                    console.log('Submission failed: No valid client selected.');
                    return;
                }
                if (orderItems.length === 0) {
                    e.preventDefault();
                    alert('Debes añadir al menos un producto al pedido.');
                    console.log('Submission failed: No items in order.');
                    return;
                }
                // Clear previous hidden inputs and generate new ones
                hiddenInputsContainer.innerHTML = '';
                orderItems.forEach((item, index) => {
                    hiddenInputsContainer.insertAdjacentHTML('beforeend', `
                        <input type="hidden" name="items[${index}][prp_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                        <input type="hidden" name="items[${index}][price]" value="${item.price}">
                    `);
                });
                console.log('Hidden inputs generated for submission:', orderItems);
            });

            // Initial render of the table
            renderTable();
            console.log("Script finished.");
        });
    </script>