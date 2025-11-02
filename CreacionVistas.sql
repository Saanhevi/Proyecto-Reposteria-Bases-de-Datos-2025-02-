-- Vistas administrador
-- 1. Listar todos los pedidos realizados, mostrando el cliente, 
-- la fecha, el estado y el total.

CREATE VIEW vw_admin_pedidos_realizados AS
SELECT 
    c.cli_nom,
    c.cli_apellido,
    p.ped_fec,
    p.ped_hora,
    p.ped_est,
    p.ped_total
FROM Pedido p
JOIN Cliente c USING (cli_cedula);

SELECT * FROM vw_admin_pedidos_realizados;

-- 2. Ver el total de ventas por día
CREATE VIEW vw_admin_ventas_dia AS
SELECT 
ped_fec , 
SUM(ped_total) AS total_ventas 
FROM Pedido 
WHERE ped_est = 'Entregado'
GROUP BY ped_fec
ORDER BY ped_fec;

SELECT * FROM vw_admin_ventas_dia;

-- 3. Top de productos más vendidos.
CREATE VIEW vw_admin_top_productos AS
SELECT pro_nom, SUM(dpe_can) AS total_vendidos
FROM Detallepedido
JOIN Productopresentacion USING(prp_id)
JOIN Producto USING (pro_id)
GROUP BY pro_nom
ORDER BY total_vendidos 
DESC LIMIT 5;

SELECT * FROM vw_admin_top_productos;

-- 4. Ingredientes con bajo stock
CREATE VIEW vw_admin_ingredientes_bajo_stock AS
SELECT 
    ing_nom,
    ing_stock,
    ing_reord
FROM Ingrediente
WHERE ing_stock < ing_reord;

SELECT * FROM vw_admin_ingredientes_bajo_stock;

-- 5. Historial de compras a proveedores
CREATE VIEW vw_admin_historial_compras AS
SELECT 
prov_nom,
com_fec,
com_tot
FROM Compra JOIN Proveedor USING(prov_id)
ORDER BY com_fec DESC;

SELECT * FROM vw_admin_historial_compras;

-- 6. Pedidos anulados
CREATE VIEW vw_admin_pedidos_anulados AS
SELECT 
cli_nom, 
cli_apellido, 
ped_fec, 
ped_hora, 
ped_total
FROM Pedido JOIN Cliente USING(cli_cedula)
WHERE ped_est = 'Anulado';

SELECT * FROM vw_admin_pedidos_anulados;

-- 7. Clientes con mayor número de compras
CREATE VIEW vw_admin_clientes_frecuentes AS
SELECT 
cli_nom, 
cli_apellido,
COUNT(ped_id) AS num_compras
FROM Pedido JOIN Cliente USING(cli_cedula)
GROUP BY cli_nom, cli_apellido
ORDER BY num_compras DESC;

SELECT * FROM vw_admin_clientes_frecuentes;

-- 8. Clientes con mayor monto total gastado
CREATE VIEW vw_admin_clientes_top_gasto AS
SELECT 
cli_nom,
cli_apellido,
SUM(ped_total) AS monto_total
FROM Pedido JOIN Cliente USING (cli_cedula)
GROUP BY cli_nom, cli_apellido
ORDER BY monto_total DESC;

SELECT * FROM vw_admin_clientes_top_gasto;

-- 9. Presentaciones y precios de productos
CREATE VIEW vw_admin_productos_precios AS
SELECT pro_nom, tam_nom, prp_precio FROM 
ProductoPresentacion 
JOIN Producto USING (pro_id)
JOIN Tamano USING (tam_id)
ORDER BY pro_nom;

SELECT * FROM vw_admin_productos_precios;

-- 10. Cajeros que participaron en pedidos
CREATE VIEW vw_admin_cajeros_pedidos AS
SELECT emp_nom, ped_fec, ped_hora, ped_total 
FROM Pedido JOIN Empleado USING (emp_id);

SELECT * FROM vw_admin_cajeros_pedidos;

-- 11. Numero de pagos realizados por tipo de método
CREATE VIEW vw_admin_metodo_pago AS
SELECT 
pag_metodo, 
COUNT(pag_id) AS num_pagos,
SUM(ped_total) AS total_recaudado
FROM Pago JOIN Pedido USING (ped_id)
GROUP BY pag_metodo;

SELECT * FROM vw_admin_metodo_pago;

-- Vistas Cajero
-- 1. Consultar todos los pedidos registrados por fecha y estado
CREATE VIEW vw_cajero_pedidos_estado AS
SELECT 
    ped_id,
    ped_fec,
    ped_est,
    ped_total
FROM Pedido
ORDER BY ped_fec DESC;

SELECT * FROM vw_cajero_pedidos_estado;

-- 2. Productos disponibles con precios y tamaños
CREATE VIEW vw_cajero_productos_disponibles AS 
SELECT 
pro_nom, 
tam_nom, 
prp_precio
FROM ProductoPresentacion
JOIN Producto USING(pro_id)
JOIN Tamano USING(tam_id)
ORDER BY pro_nom;

SELECT * FROM vw_cajero_productos_disponibles;

-- 3. Pedidos pendientes de entrega
CREATE VIEW vw_cajero_pedidos_pendientes_entrega AS
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

SELECT * FROM vw_cajero_pedidos_pendientes_entrega;

-- 4. Pedidos pendientes de cobro
CREATE VIEW vw_cajero_pedidos_pendientes_cobro AS
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

SELECT * FROM vw_cajero_pedidos_pendientes_cobro;

-- Vistas Repostero
-- 1. Pedidos pendientes de preparación
CREATE VIEW vw_repostero_pedidos_pendientes AS
SELECT 
ped_id, 
ped_fec, 
ped_hora 
FROM Pedido 
WHERE ped_est = 'Pendiente';

SELECT * FROM vw_repostero_pedidos_pendientes;

-- 2. Detalle de pedidos pendientes (productos, cantidades, tamaños)
CREATE VIEW vw_repostero_detalle_pedidos_pendientes AS
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

SELECT * FROM vw_repostero_detalle_pedidos_pendientes;

-- 3. Ingredientes disponibles y stock actual
CREATE VIEW vw_repostero_stock_ingredientes AS
SELECT 
ing_nom,
ing_stock,
ing_reord,
ing_um
FROM Ingrediente
ORDER BY ing_nom;

SELECT * FROM vw_repostero_stock_ingredientes;

-- 4. Cantidad total de cada producto pendiente de preparar
CREATE VIEW vw_repostero_consolidado_productos AS
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

SELECT * FROM vw_repostero_consolidado_productos;

-- 5. Cantidad total por ingrediente necesaria según pedidos pendientes
CREATE VIEW vw_repostero_ingredientes_necesarios AS
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

SELECT * FROM vw_repostero_ingredientes_necesarios;