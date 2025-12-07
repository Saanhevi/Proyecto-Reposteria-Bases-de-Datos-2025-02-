USE ReposteriaDB;

-- ================================================================
-- Script de actualizaciones y eliminaciones
--
-- Este archivo contiene operaciones de actualizacion (UPDATE) y
-- eliminacion (DELETE) agrupadas segun los permisos de cada rol
-- (Administrador, Cajero y Repostero) en el sistema de reposteria.  Para
-- cada operacion se presenta primero una version general con nombres
-- de variables a reemplazar y despues un ejemplo concreto
-- utilizando valores existentes de la BD. 
-- ================================================================

/*
========================================================================
  OPERACIONES PARA EL ROL: ADMINISTRADOR

  El administrador supervisa la operacion general del negocio.  Sus
  funciones incluyen consultar informacion sobre ventas, compras,
  clientes, productos e inventario; registrar y modificar proveedores,
  productos y recetas; gestionar las compras de ingredientes y
  actualizar sus existencias; y registrar nuevos empleados asignando
  sus roles (por ejemplo, cajero o repostero). 

========================================================================
*/


-- 1. Actualizar el precio de una presentacion de producto.

-- Version general
UPDATE ProductoPresentacion
SET prp_precio = nuevoPrecio
WHERE pro_id = productoId
  AND tam_id = tamanoId;

-- Ejemplo: incrementar el precio de la presentacion (pro_id=1, tam_id=1) a 5500
UPDATE ProductoPresentacion
SET prp_precio = 5500
WHERE pro_id = 1
  AND tam_id = 1;

-- 2. Ajustar el stock y el punto de reorden de un ingrediente.

-- Version general
UPDATE Ingrediente
SET ing_stock = nuevoStock,
    ing_reord = nuevoReorden
WHERE ing_id = ingredienteId;

-- Ejemplo: actualizar el stock de Harina de trigo (ing_id=1) a 30 y el
--         punto de reorden a 4
UPDATE Ingrediente
SET ing_stock = 30,
    ing_reord = 4
WHERE ing_id = 1;

-- (El administrador no actualiza datos de clientes; esta tarea corresponde al Cajero.)

-- 3. Actualizar los datos de un proveedor.

-- Version general
UPDATE Proveedor
SET prov_nom = nuevoNombreProveedor,
    prov_tel = nuevoTelefonoProveedor,
    prov_dir = nuevaDireccionProveedor
WHERE prov_id = proveedorId;

-- Ejemplo: actualizar la direccion del proveedor 1
UPDATE Proveedor
SET prov_dir = 'Calle 99 #88-77'
WHERE prov_id = 1;

-- 4. Actualizar los datos de un empleado (nombre y telefono).

-- Version general
UPDATE Empleado
SET emp_nom = nuevoNombreEmpleado,
    emp_tel = nuevoTelefonoEmpleado
WHERE emp_id = empleadoId;

-- Ejemplo: cambiar el telefono del empleado 1016797832
UPDATE Empleado
SET emp_tel = '3209876543'
WHERE emp_id = 1016797832;

-- 4a. Actualizar el turno de un cajero.

-- Version general
UPDATE Cajero
SET caj_turno = nuevoTurno
WHERE emp_id = empleadoId;

-- Ejemplo: cambiar el turno del cajero 1016797813 a 'Noche'
UPDATE Cajero
SET caj_turno = 'Noche'
WHERE emp_id = 1016797813;

-- 4b. Actualizar la especialidad de un repostero.

-- Version general
UPDATE Repostero
SET rep_especialidad = nuevaEspecialidad
WHERE emp_id = empleadoId;

-- Ejemplo: actualizar la especialidad del repostero 1016797213
UPDATE Repostero
SET rep_especialidad = 'Postres frios'
WHERE emp_id = 1016797213;


-- 5. Actualizar el nombre de un producto o su receta asociada.

-- Version general
UPDATE Producto
SET pro_nom = nuevoNombreProducto,
    rec_id  = nuevaRecetaId
WHERE pro_id = productoId;

-- Ejemplo: cambiar el nombre del producto 2 a 'Pie de limon' y asociarlo a la receta 2
UPDATE Producto
SET pro_nom = 'Pie de limon',
    rec_id  = 2
WHERE pro_id = 2;

-- 6. Actualizar el nombre de una receta.

-- Version general
UPDATE Receta
SET rec_nom = nuevoNombreReceta
WHERE rec_id = recetaId;

-- Ejemplo: renombrar la receta 4 a 'Tiramisu Clasico'
UPDATE Receta
SET rec_nom = 'Tiramisu Clasico'
WHERE rec_id = 4;

-- 7. Ajustar la cantidad de un ingrediente en una receta.

-- Version general
UPDATE DetalleReceta
SET dre_can = nuevaCantidad
WHERE rec_id = recetaId
  AND ing_id = ingredienteId;

-- Ejemplo: ajustar la cantidad de harina (ing_id=1) en la receta 1 a 0.6
UPDATE DetalleReceta
SET dre_can = 0.60
WHERE rec_id = 1
  AND ing_id = 1;

-- 8. Actualizar datos de una compra (fecha o total).

-- Version general
UPDATE Compra
SET com_fec = nuevaFecha,
    com_tot = nuevoTotal
WHERE com_id = compraId;

-- Ejemplo: modificar la compra 1 para que el total sea 55000
UPDATE Compra
SET com_tot = 55000
WHERE com_id = 1;

-- 9. Actualizar detalles de compra (cantidad y precio).

-- Version general
UPDATE DetalleCompra
SET dco_can = nuevaCantidad,
    dco_pre = nuevoPrecio
WHERE com_id = compraId
  AND ing_id = ingredienteId;

-- Ejemplo: cambiar la cantidad de harina (ing_id=1) en la compra 1 a 10 kg con precio 2500
UPDATE DetalleCompra
SET dco_can = 10.0,
    dco_pre = 2500
WHERE com_id = 1
  AND ing_id = 1;

-- 10. Asignar un empleado existente como cajero con un turno determinado.

-- Version general
INSERT INTO Cajero (emp_id, caj_turno) VALUES (empleadoId, nuevoTurno);

-- Ejemplo: asignar al empleado 1016797223 como cajero con turno 'Tarde'
INSERT INTO Cajero (emp_id, caj_turno) VALUES (1016797223, 'Tarde');

-- 11. Asignar un empleado existente como repostero con una especialidad.

-- Version general
INSERT INTO Repostero (emp_id, rep_especialidad) VALUES (empleadoId, nuevaEspecialidad);

-- Ejemplo: asignar al empleado 1066280984 como repostero especializado en 'Tortas al horno'
INSERT INTO Repostero (emp_id, rep_especialidad) VALUES (1066280984, 'Tortas al horno');

/*
========================================================================
  OPERACIONES PARA EL ROL: CAJERO

  El cajero interactua con el cliente durante el proceso de venta.
  Puede insertar y actualizar informacion de los clientes, registrar
  nuevos pedidos y sus detalles, registrar los pagos realizados,
  actualizar el estado de los pedidos (Pendiente, Entregado o Anulado)
  y consultar productos y precios. 
========================================================================
*/

-- 1. Cambiar el estado de un pedido.

-- Version general
UPDATE Pedido
SET ped_est = nuevoEstado
WHERE ped_id = pedidoId;

-- Ejemplo: marcar el pedido 4 como 'Entregado'
UPDATE Pedido
SET ped_est = 'Entregado'
WHERE ped_id = 4;

-- 2. Modificar el metodo de pago de un pedido.

-- Version general
UPDATE Pago
SET pag_metodo = nuevoMetodoPago
WHERE pag_id = pagoId;

-- Ejemplo: cambiar el metodo de pago del registro 1 a 'Transferencia'
UPDATE Pago
SET pag_metodo = 'Transferencia'
WHERE pag_id = 1;

-- 3. Actualizar la cantidad y el subtotal de un detalle de pedido.

-- Version general
UPDATE DetallePedido
SET dpe_can      = nuevaCantidad,
    dpe_subtotal = nuevoSubtotal
WHERE ped_id = pedidoId
  AND prp_id = presentacionId;

-- Ejemplo: modificar el detalle del pedido 1 (prp_id=1) a 3 unidades y 15000 de subtotal
UPDATE DetallePedido
SET dpe_can      = 3,
    dpe_subtotal = 15000
WHERE ped_id = 1
  AND prp_id = 1;

-- 4. Registrar o modificar la informacion de un cliente (telefono y direccion).

-- Version general
UPDATE Cliente
SET cli_tel = nuevoTelefono,
    cli_dir = nuevaDireccion
WHERE cli_cedula = clienteCedula;

-- Ejemplo: actualizar el telefono y la direccion del cliente 1036897912
UPDATE Cliente
SET cli_tel = '3001112222',
    cli_dir = 'Carrera 12 #34-56'
WHERE cli_cedula = 1036897912;

/*
========================================================================
  OPERACIONES PARA EL ROL: REPOSTERO

  El repostero esta encargado de la produccion.  Puede consultar
  los pedidos con estado Pendiente o Preparado, consultar las
  recetas e ingredientes y Actualizar el estado de los pedidos (Pendiente, Entregado o Anulado).
========================================================================
*/

-- 1. Marcar un pedido segun el estado.

-- Version general
UPDATE Pedido
SET ped_est = estado
WHERE ped_id = pedidoId;

-- Ejemplo: marcar el pedido 4 como 'Preparado'
UPDATE Pedido
SET ped_est = 'Preparado'
WHERE ped_id = 4;
