USE ReposteriaDB;

-- Consultas

-- Consultas administrador
-- 1. Listar todos los pedidos realizados, mostrando el cliente, 
-- la fecha, el estado y el total.

SELECT 
    c.cli_nom,
    c.cli_apellido,
    p.ped_fec,
    p.ped_hora,
    p.ped_est,
    p.ped_total
FROM Pedido p
JOIN Cliente c USING (cli_cedula);

-- 2. Ver el total de ventas por dia

SELECT 
ped_fec , 
SUM(ped_total) AS total_ventas 
FROM Pedido 
WHERE ped_est = 'Entregado'
GROUP BY ped_fec
ORDER BY ped_fec;

-- 3. Consultar el top de productos mas vendidos.
SELECT pro_nom, SUM(dpe_can) AS total_vendidos
FROM DetallePedido
JOIN ProductoPresentacion USING(prp_id)
JOIN Producto USING (pro_id)
GROUP BY pro_nom
ORDER BY total_vendidos DESC
LIMIT 5;

-- 4. Listar los ingredientes con bajo stock 
SELECT 
    ing_nom,
    ing_stock,
    ing_reord
FROM Ingrediente
WHERE ing_stock < ing_reord;

-- 5. Ver historial de compras a proveedores
SELECT 
prov_nom,
com_fec,
com_tot
FROM Compra JOIN Proveedor USING(prov_id)
ORDER BY com_fec DESC;

-- 6. Consultar Pedidos anulados
SELECT 
cli_nom, 
cli_apellido, 
ped_fec, 
ped_hora, 
ped_total
FROM Pedido JOIN Cliente USING(cli_cedula)
WHERE ped_est = 'Anulado';

-- 7. Listar los clientes con mayor numero de compras
SELECT 
cli_nom, 
cli_apellido,
COUNT(ped_id) AS num_compras
FROM Pedido JOIN Cliente USING(cli_cedula)
GROUP BY cli_nom, cli_apellido
ORDER BY num_compras DESC;

-- 8. Listar los clientes con mayor monto total gastado
SELECT 
cli_nom,
cli_apellido,
SUM(ped_total) AS monto_total
FROM Pedido JOIN Cliente USING (cli_cedula)
GROUP BY cli_nom, cli_apellido
ORDER BY monto_total DESC;

-- 9. Visualizar las presentaciones y precios de los productos disponibles
SELECT pro_nom, tam_nom, prp_precio FROM 
ProductoPresentacion 
JOIN Producto USING (pro_id)
JOIN Tamano USING (tam_id)
ORDER BY pro_nom;

-- 10. Consultar que cajeros han participado en cada pedido
SELECT emp_nom, ped_fec, ped_hora, ped_total 
FROM Pedido JOIN Empleado USING (emp_id);

-- 11. Listar los clientes registrados en el sistema.
SELECT 
    cli_cedula,
    cli_apellido,
    cli_nom,
    cli_tel,
    cli_dir
FROM Cliente
ORDER BY cli_apellido;

-- 12.Numero de pagos realizados por tipo de metodo (efectivo, tarjeta, transferencia).
SELECT 
pag_metodo, 
COUNT(pag_id) AS num_pagos,
SUM(ped_total) AS total_recaudado
FROM Pago JOIN Pedido USING (ped_id)
GROUP BY pag_metodo;

-- Consultas Cajero
-- 1. Consultar todos los pedidos registrados por fecha y estado.
SELECT 
    ped_id,
    ped_fec,
    ped_est,
    ped_total
FROM Pedido
ORDER BY ped_fec DESC;

-- 2. Ver el detalle de un pedido especifico (productos, cantidades y subtotales).
SELECT 
ped_id, 
pro_nom, 
tam_nom, 
dpe_can, 
dpe_subtotal 
FROM Pedido 
JOIN DetallePedido USING (ped_id)
JOIN ProductoPresentacion USING (prp_id)
JOIN Producto USING (pro_id)
JOIN Tamano USING (tam_id)
WHERE ped_id = 1; -- Cambiar por el ID del pedido que se desee consultar

-- 3. Listar los clientes registrados en el sistema.
SELECT 
    cli_cedula,
    cli_apellido,
    cli_nom,
    cli_tel,
    cli_dir
FROM Cliente
ORDER BY cli_apellido;

-- 4. Consultar el historial de compras de un cliente
SELECT 
cli_nom, 
cli_apellido, 
ped_fec, 
ped_est, 
ped_total 
FROM Cliente JOIN Pedido USING (cli_cedula)
WHERE cli_cedula = 1016797812
ORDER BY ped_fec DESC;

-- 5. Visualizar los productos disponibles con sus precios y tamanos.
SELECT 
pro_nom, 
    tam_nom, 
    prp_precio
FROM ProductoPresentacion
JOIN Producto USING(pro_id)
JOIN Tamano USING(tam_id)
ORDER BY pro_nom;

-- 6. Consultar los pedidos pendientes de entrega 
SELECT 
    ped_id,
    cli_nom,
    cli_apellido,
    ped_fec,
    ped_total
FROM Pedido 
JOIN Cliente USING(cli_cedula)
WHERE ped_est = 'Pendiente'
ORDER BY ped_fec;

-- 7. Consultar los pedidos pendientes de cobro
SELECT 
    ped_id,
    cli_nom,
    cli_apellido,
    cli_tel,
    ped_fec,
    ped_total
FROM Pedido 
JOIN Cliente USING(cli_cedula)
LEFT JOIN Pago USING(ped_id) 
WHERE pag_id IS NULL
ORDER BY ped_fec;

-- Consultas repostero
-- 1. Listar los pedidos pendientes de preparacion
SELECT 
ped_id, 
ped_fec, 
ped_hora 
FROM Pedido 
WHERE ped_est = 'Pendiente';

-- 2. Ver el detalle de cada pedido pendiente (productos, cantidades, tamanos).
SELECT 
ped_id, 
pro_nom, 
tam_nom, 
dpe_can
FROM Pedido
JOIN DetallePedido USING (ped_id)
JOIN ProductoPresentacion USING (prp_id)
JOIN Tamano USING (tam_id)
JOIN Producto USING (pro_id)
WHERE ped_est = 'Pendiente'
ORDER BY ped_id;

-- 3.Consultar la receta de un producto con un tamano en especifico (ingredientes y cantidades requeridas)
SELECT 
pro_nom, 
    tam_nom, 
    ing_nom, 
    (dre_can * tam_factor) AS cantidad_total,
    ing_um
FROM Producto
JOIN ProductoPresentacion USING (pro_id)
JOIN Tamano USING (tam_id)
JOIN Receta USING (rec_id) 
JOIN DetalleReceta USING (rec_id)
JOIN Ingrediente USING (ing_id)
WHERE pro_nom = 'Torta de chocolate' -- Se especifica el producto
  AND tam_nom = 'Mediano'; -- Se especifica el tamano
  
-- 4. Listar los ingredientes disponibles y su stock actual
SELECT 
ing_nom,
ing_stock,
ing_reord,
ing_um
FROM Ingrediente
ORDER BY ing_nom;

-- 5. Ver la cantidad total de cada producto pendiente de preparar (por consolidacion de pedidos)
SELECT 
pro_nom,
    tam_nom,
    SUM(dpe_can) AS cantidadTotal  
FROM Pedido
JOIN DetallePedido USING (ped_id)
JOIN ProductoPresentacion USING (prp_id)
JOIN Producto USING (pro_id)
JOIN Tamano USING (tam_id)
WHERE ped_est = 'Pendiente'
GROUP BY pro_nom, tam_nom;

-- 6. Consultar la cantidad total por ingrediente necesaria segun los pedidos pendientes 
-- (puede variar segun los tamanos)
SELECT 
ing_nom ,
SUM(dpe_can*dre_can*tam_factor) AS cantidadTotal,
ing_um
FROM Pedido
JOIN DetallePedido USING (ped_id)
JOIN ProductoPresentacion USING (prp_id)
JOIN Producto USING (pro_id)
JOIN Tamano USING (tam_id)
JOIN Receta USING (rec_id)
JOIN DetalleReceta USING (rec_id)
JOIN Ingrediente USING (ing_id)
WHERE ped_est = 'Pendiente'
GROUP BY ing_nom, ing_um
ORDER BY ing_nom;
