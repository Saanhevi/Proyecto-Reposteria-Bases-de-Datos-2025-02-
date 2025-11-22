-- Script de creación de usuarios y perfiles
-- Crear rol admin (si no existe)
CREATE ROLE IF NOT EXISTS 'role_admin'@'localhost';

-- Crear usuario admin (si no existe) 
CREATE USER IF NOT EXISTS '123456'@'localhost' IDENTIFIED BY '12345!';

-- Asignar rol al usuario
GRANT 'role_admin'@'localhost' TO '123456'@'localhost';

-- Definir el rol por defecto para el usuario
SET DEFAULT ROLE 'role_admin'@'localhost' TO '123456'@'localhost';

-- Asignar permisos a las tablas
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Cliente TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Empleado TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Cajero TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Repostero TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Domiciliario TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Pedido TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Pago TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.DetallePedido TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.ProductoPresentacion TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Tamano TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Producto TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Receta TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.DetalleReceta TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Ingrediente TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.DetalleCompra TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Compra TO 'role_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ReposteriaDB.Proveedor TO 'role_admin'@'localhost';

-- Asignar permisos de solo lectura sobre las vistas del administrador
GRANT SELECT ON ReposteriaDB.vw_admin_pedidos_realizados TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_ventas_dia TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_top_productos TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_ingredientes_bajo_stock TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_historial_compras TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_pedidos_anulados TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_clientes_frecuentes TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_clientes_top_gasto TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_productos_disponibles TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_cajeros_pedidos TO 'role_admin'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_admin_metodo_pago TO 'role_admin'@'localhost';

-- Crear rol cajero (si no existe)
CREATE ROLE IF NOT EXISTS 'role_cajero'@'localhost';

-- Crear usuario cajero (si no existe)
CREATE USER IF NOT EXISTS '1016797813'@'localhost' IDENTIFIED BY '12345!';

-- Asignar rol al usuario
GRANT 'role_cajero'@'localhost' TO '1016797813'@'localhost';

-- Definir el rol por defecto para el usuario
SET DEFAULT ROLE 'role_cajero'@'localhost' TO '1016797813'@'localhost';

-- Asignar permisos a las tablas
GRANT SELECT, INSERT, UPDATE ON ReposteriaDB.Cliente TO 'role_cajero'@'localhost';
GRANT SELECT , INSERT, UPDATE ON ReposteriaDB.Pedido TO 'role_cajero'@'localhost';
GRANT SELECT , INSERT, UPDATE ON ReposteriaDB.DetallePedido TO 'role_cajero'@'localhost';
GRANT SELECT , INSERT ON ReposteriaDB.Pago TO 'role_cajero'@'localhost';
GRANT SELECT ON ReposteriaDB.Producto TO 'role_cajero'@'localhost';
GRANT SELECT ON ReposteriaDB.Tamano TO 'role_cajero'@'localhost';
GRANT SELECT ON ReposteriaDB.ProductoPresentacion TO 'role_cajero'@'localhost';

-- Asignar permisos a las vistas 
GRANT SELECT ON ReposteriaDB.vw_cajero_pedidos_estado TO 'role_cajero'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_cajero_pedidos_pendientes TO 'role_cajero'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_cajero_pedidos_pendientes_cobro TO 'role_cajero'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_cajero_productos_disponibles TO 'role_cajero'@'localhost';

-- Crear rol repostero (si no existe)
CREATE ROLE IF NOT EXISTS 'role_repostero'@'localhost';

-- Crear usuario repostero (si no existe)
CREATE USER IF NOT EXISTS '1016797832'@'localhost' IDENTIFIED BY '12345!';

-- Asignar rol al usuario
GRANT 'role_repostero'@'localhost' TO '1016797832'@'localhost';

-- Definir el rol por defecto para el usuario
SET DEFAULT ROLE 'role_repostero'@'localhost' TO '1016797832'@'localhost';

-- Asignar permisos a las tablas 
GRANT SELECT ON ReposteriaDB.Ingrediente TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.Receta TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.DetalleReceta TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.Producto TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.Tamano TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.ProductoPresentacion TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.Pedido TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.DetallePedido TO 'role_repostero'@'localhost';

-- Asignar permisos a las vistas
GRANT SELECT ON ReposteriaDB.vw_repostero_consolidado_productos TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_repostero_detalle_pedidos_pendientes TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_repostero_ingredientes_necesarios TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_repostero_pedidos_pendientes TO 'role_repostero'@'localhost';
GRANT SELECT ON ReposteriaDB.vw_repostero_stock_ingredientes TO 'role_repostero'@'localhost';

SELECT user, host FROM mysql.user;
