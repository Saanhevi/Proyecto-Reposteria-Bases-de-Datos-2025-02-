USE ReposteriaDB;

-- Vistas administrador
-- 1. Listar todos los pedidos realizados
DROP VIEW IF EXISTS vw_admin_pedidos_realizados;
CREATE VIEW vw_admin_pedidos_realizados AS
SELECT 
    p.ped_id,
    c.cli_cedula,
    CONCAT(c.cli_nom, ' ', c.cli_apellido) AS cli_nombre_completo,
    e.emp_nom AS cajero_nom,
    p.ped_fec,
    p.ped_hora,
    p.ped_est,
    p.ped_total
FROM Pedido p
JOIN Cliente c USING (cli_cedula)
JOIN Empleado e USING (emp_id);

-- 2. Top de productos mas vendidos.
DROP VIEW IF EXISTS vw_admin_top_productos;
CREATE VIEW vw_admin_top_productos AS
SELECT 
    pro_nom, 
    SUM(dpe_can) AS total_vendidos
FROM DetallePedido
JOIN ProductoPresentacion USING(prp_id)
JOIN Producto USING (pro_id)
GROUP BY pro_nom
ORDER BY total_vendidos DESC
LIMIT 5;

-- 3. Ingredientes con bajo stock
DROP VIEW IF EXISTS vw_admin_ingredientes_bajo_stock;
CREATE VIEW vw_admin_ingredientes_bajo_stock AS
SELECT 
    ing_nom,
    ing_stock,
    ing_reord
FROM Ingrediente
WHERE ing_stock < ing_reord;

-- 4. Pedidos anulados
DROP VIEW IF EXISTS vw_admin_pedidos_anulados;
CREATE VIEW vw_admin_pedidos_anulados AS
SELECT 
    cli_cedula,
    CONCAT(cli_nom, ' ', cli_apellido) AS cli_nombre_completo,
    emp_nom AS cajero_nom,
    ped_fec,
    ped_hora,
    ped_est,
    ped_total
FROM Pedido 
JOIN Cliente USING(cli_cedula)
JOIN Empleado USING (emp_id)
WHERE ped_est = 'Anulado';

-- 5. Ingredientes actuales
DROP VIEW IF EXISTS vw_admin_ingredientes;
CREATE VIEW vw_admin_ingredientes AS
SELECT 
    ing_nom,
    CONCAT(ing_stock, ' ', ing_um) AS ing_stock_um,
    CONCAT(ing_reord, ' ', ing_um) AS ing_reord_um
FROM Ingrediente;

-- 6. Clientes actuales
DROP VIEW IF EXISTS vw_admin_clientes;
CREATE VIEW vw_admin_clientes AS
SELECT
    cli_cedula,
    cli_nom,
    cli_apellido,
    cli_tel,
    cli_dir
FROM Cliente;

-- 7. Proveedores actuales
DROP VIEW IF EXISTS vw_admin_proveedores;
CREATE VIEW vw_admin_proveedores AS
SELECT     
    prov_id,
    prov_nom,
    prov_tel,
    prov_dir
FROM Proveedor;

-- 8. Cajeros actuales
DROP VIEW IF EXISTS vw_admin_cajeros;
CREATE VIEW vw_admin_cajeros AS
SELECT    
    emp_id,
    emp_nom,
    emp_tel,
    caj_turno
FROM Cajero JOIN Empleado USING(emp_id);

-- 9. Reposteros actuales
DROP VIEW IF EXISTS vw_admin_reposteros;
CREATE VIEW vw_admin_reposteros AS
SELECT 
    emp_id,
    emp_nom,
    emp_tel,
    rep_especialidad
FROM Repostero JOIN Empleado USING(emp_id);

-- 10. Domiciliarios actuales
DROP VIEW IF EXISTS vw_admin_domiciliarios;
CREATE VIEW vw_admin_domiciliarios AS
SELECT
    emp_id,
    emp_nom,
    emp_tel,
    dom_medTrans
FROM Domiciliario JOIN Empleado USING(emp_id);

-- 11. Pedidos pagados
DROP VIEW IF EXISTS vw_admin_pedidos_pagados;
CREATE VIEW vw_admin_pedidos_pagados AS
SELECT 
    pag_id,
    ped_id,
    CONCAT(cli_nom, ' ', cli_apellido) AS cli_nombre_completo,    
    pag_metodo,
    pag_fec,
    pag_hora,
    ped_total
FROM Pago 
JOIN Pedido USING (ped_id)
JOIN Cliente USING (cli_cedula);

-- 12. Ventas por mes                                                                         
DROP VIEW IF EXISTS vw_admin_ventas_por_mes;                                                  
CREATE VIEW vw_admin_ventas_por_mes AS                                                        
SELECT                                                                                        
     DATE_FORMAT(ped_fec, '%Y-%m') AS mes,                                                     
     SUM(ped_total) AS total                                                                   
FROM Pedido                                                                                    
WHERE ped_est = 'Entregado'                                                                   
GROUP BY mes                                                                                  
ORDER BY mes; 

-- 13. Ventas por dia
DROP VIEW IF EXISTS vw_admin_ventas_dia;
CREATE VIEW vw_admin_ventas_dia AS
SELECT 
    ped_fec,
    SUM(ped_total) AS total_ventas
FROM Pedido
WHERE ped_est = 'Entregado'
GROUP BY ped_fec
ORDER BY ped_fec;

-- 14. Historial de compras
DROP VIEW IF EXISTS vw_admin_historial_compras;
CREATE VIEW vw_admin_historial_compras AS
SELECT 
    prov_nom,
    com_fec,
    com_tot
FROM Compra JOIN Proveedor USING(prov_id)
ORDER BY com_fec DESC;

-- 15. Clientes frecuentes (por numero de compras)
DROP VIEW IF EXISTS vw_admin_clientes_frecuentes;
CREATE VIEW vw_admin_clientes_frecuentes AS
SELECT 
    cli_cedula,
    cli_nom,
    cli_apellido,
    COUNT(ped_id) AS num_compras
FROM Pedido JOIN Cliente USING(cli_cedula)
GROUP BY cli_cedula, cli_nom, cli_apellido
ORDER BY num_compras DESC;

-- 16. Clientes top por gasto total
DROP VIEW IF EXISTS vw_admin_clientes_top_gasto;
CREATE VIEW vw_admin_clientes_top_gasto AS
SELECT 
    cli_cedula,
    cli_nom,
    cli_apellido,
    SUM(ped_total) AS monto_total
FROM Pedido JOIN Cliente USING (cli_cedula)
GROUP BY cli_cedula, cli_nom, cli_apellido
ORDER BY monto_total DESC;

-- 17. Productos disponibles con precios y tamanos
DROP VIEW IF EXISTS vw_admin_productos_disponibles;
CREATE VIEW vw_admin_productos_disponibles AS
SELECT pro_nom, tam_nom, prp_precio FROM 
ProductoPresentacion 
JOIN Producto USING (pro_id)
JOIN Tamano USING (tam_id)
ORDER BY pro_nom;

-- 18. Cajeros que atendieron pedidos
DROP VIEW IF EXISTS vw_admin_cajeros_pedidos;
CREATE VIEW vw_admin_cajeros_pedidos AS
SELECT 
    ped_id,
    ped_fec,
    ped_hora,
    ped_total,
    emp_nom
FROM Pedido JOIN Empleado USING (emp_id);

-- 19. Resumen de pagos por metodo
DROP VIEW IF EXISTS vw_admin_metodo_pago;
CREATE VIEW vw_admin_metodo_pago AS
SELECT 
    pag_metodo, 
    COUNT(pag_id) AS num_pagos,
    SUM(ped_total) AS total_recaudado
FROM Pago JOIN Pedido USING (ped_id)
GROUP BY pag_metodo;

-- Vistas Cajero
-- 1. Consultar todos los pedidos registrados por fecha y estado
DROP VIEW IF EXISTS vw_cajero_pedidos_estado;
CREATE VIEW vw_cajero_pedidos_estado AS
SELECT 
    ped_id,
    ped_fec,
    ped_est,
    ped_total
FROM Pedido
ORDER BY ped_fec DESC;

-- 2. Productos disponibles con precios y tamanos
DROP VIEW IF EXISTS vw_cajero_productos_disponibles;
CREATE VIEW vw_cajero_productos_disponibles AS 
SELECT 
pro_nom, 
    tam_nom, 
    prp_precio
FROM ProductoPresentacion
JOIN Producto USING(pro_id)
JOIN Tamano USING(tam_id)
ORDER BY pro_nom;

-- 3. Pedidos pendientes de entrega
DROP VIEW IF EXISTS vw_cajero_pedidos_pendientes;
CREATE VIEW vw_cajero_pedidos_pendientes AS
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

-- 5. Pedidos con detalle y pago (para consultas rápidas del cajero)
DROP VIEW IF EXISTS vw_cajero_pedidos_detalle;
CREATE VIEW vw_cajero_pedidos_detalle AS
SELECT 
    p.ped_id,
    p.ped_fec,
    p.ped_hora,
    p.ped_est,
    p.ped_total,
    c.cli_cedula,
    CONCAT(c.cli_nom, ' ', c.cli_apellido) AS cli_nombre,
    c.cli_tel,
    e.emp_nom AS cajero_nom,
    pg.pag_metodo,
    pg.pag_id IS NOT NULL AS pagado
FROM Pedido p
JOIN Cliente c USING (cli_cedula)
LEFT JOIN Pago pg USING (ped_id)
LEFT JOIN Empleado e ON p.emp_id = e.emp_id;

-- 6. Resumen diario de ventas (solo pedidos entregados)
DROP VIEW IF EXISTS vw_cajero_resumen_ventas_dia;
CREATE VIEW vw_cajero_resumen_ventas_dia AS
SELECT 
    ped_fec,
    SUM(ped_total) AS total_dia,
    COUNT(*) AS pedidos_entregados
FROM Pedido
WHERE ped_est = 'Entregado'
GROUP BY ped_fec
ORDER BY ped_fec DESC;

-- 7. Recaudo por método de pago (para caja)
DROP VIEW IF EXISTS vw_cajero_pagos_por_metodo;
CREATE VIEW vw_cajero_pagos_por_metodo AS
SELECT 
    pag_metodo,
    COUNT(pag_id) AS num_pagos,
    SUM(ped_total) AS total_recaudado
FROM Pago 
JOIN Pedido USING (ped_id)
GROUP BY pag_metodo;

-- 4. Pedidos pendientes de cobro
DROP VIEW IF EXISTS vw_cajero_pedidos_pendientes_cobro;
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

-- Vistas Repostero
-- 1. Pedidos pendientes de preparacion
DROP VIEW IF EXISTS vw_repostero_pedidos_pendientes;
CREATE VIEW vw_repostero_pedidos_pendientes AS
SELECT 
ped_id, 
ped_fec, 
ped_hora 
FROM Pedido 
WHERE ped_est = 'Pendiente';

-- 2. Detalle de pedidos pendientes (productos, cantidades, tamanos)
DROP VIEW IF EXISTS vw_repostero_detalle_pedidos_pendientes;
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

-- 3. Ingredientes disponibles y stock actual
DROP VIEW IF EXISTS vw_repostero_stock_ingredientes;
CREATE VIEW vw_repostero_stock_ingredientes AS
SELECT 
ing_nom,
ing_stock,
ing_reord,
ing_um
FROM Ingrediente
ORDER BY ing_nom;

-- 4. Cantidad total de cada producto pendiente de preparar
DROP VIEW IF EXISTS vw_repostero_consolidado_productos;
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

-- 5. Cantidad total por ingrediente necesaria segun pedidos pendientes
DROP VIEW IF EXISTS vw_repostero_ingredientes_necesarios;
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

-- 6. Pedidos activos (Pendiente o Preparado) con cliente
DROP VIEW IF EXISTS vw_repostero_pedidos_activos;
CREATE VIEW vw_repostero_pedidos_activos AS
SELECT 
    p.ped_id,
    p.ped_fec,
    p.ped_hora,
    p.ped_est,
    p.ped_total,
    CONCAT(c.cli_nom, ' ', c.cli_apellido) AS cliente
FROM Pedido p
LEFT JOIN Cliente c USING (cli_cedula)
WHERE p.ped_est IN ('Pendiente','Preparado')
ORDER BY p.ped_fec DESC, p.ped_id DESC;

-- 7. Requerimientos de ingredientes por pedido (para validar stock)
DROP VIEW IF EXISTS vw_repostero_requerimientos_pedido;
CREATE VIEW vw_repostero_requerimientos_pedido AS
SELECT 
    dp.ped_id,
    dr.ing_id,
    i.ing_nom,
    SUM(dp.dpe_can * dr.dre_can * t.tam_factor) AS cantidad_requerida,
    i.ing_stock,
    GREATEST(SUM(dp.dpe_can * dr.dre_can * t.tam_factor) - i.ing_stock, 0) AS faltante
FROM DetallePedido dp
JOIN ProductoPresentacion pp ON dp.prp_id = pp.prp_id
JOIN Tamano t ON pp.tam_id = t.tam_id
JOIN Producto pr ON pp.pro_id = pr.pro_id
JOIN Receta r ON pr.rec_id = r.rec_id
JOIN DetalleReceta dr ON r.rec_id = dr.rec_id
JOIN Ingrediente i ON dr.ing_id = i.ing_id
GROUP BY dp.ped_id, dr.ing_id, i.ing_nom, i.ing_stock;

-- 8. Ingredientes faltantes por pedido (solo cuando no alcanza el stock)
DROP VIEW IF EXISTS vw_repostero_faltantes_pedido;
CREATE VIEW vw_repostero_faltantes_pedido AS
SELECT *
FROM vw_repostero_requerimientos_pedido
WHERE faltante > 0;
