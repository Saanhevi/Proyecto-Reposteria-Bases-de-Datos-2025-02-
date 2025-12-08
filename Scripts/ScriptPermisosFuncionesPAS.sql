USE ReposteriaDB;

-- =============================================================
--  Asignacion de permisos de ejecucion para funciones y PAS
--  Roles considerados: admin, cajero y repostero
--  Ejecutar con un usuario con privilegios de SUPER o GRANT OPTION
-- =============================================================

-- Roles base (se crean solo si no existen)
CREATE ROLE IF NOT EXISTS 'role_admin'@'localhost';
CREATE ROLE IF NOT EXISTS 'role_cajero'@'localhost';
CREATE ROLE IF NOT EXISTS 'role_repostero'@'localhost';

-- ----------------------------
-- Admin: puede ejecutar todo
-- ----------------------------
GRANT EXECUTE ON FUNCTION ReposteriaDB.fn_admin_num_ped_entregados TO 'role_admin'@'localhost';
GRANT EXECUTE ON FUNCTION ReposteriaDB.fn_admin_num_ped_activos TO 'role_admin'@'localhost';
GRANT EXECUTE ON FUNCTION ReposteriaDB.fn_admin_num_productos TO 'role_admin'@'localhost';
GRANT EXECUTE ON FUNCTION ReposteriaDB.fn_admin_num_empleados TO 'role_admin'@'localhost';

GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_cliente TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_actu_cliente TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_find_cliente TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_cliente TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_admin_buscar_clientes TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_admin_buscar_ingredientes TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_ingrediente TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_ingrediente TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_ingrediente TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_proveedor TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_proveedor TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_proveedor TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_empleado TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_empleado TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_empleado TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_cajero TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_cajero TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_cajero TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_repostero TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_repostero TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_repostero TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_receta TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_receta TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_receta TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_detalle_receta TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_detalle_receta TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_producto TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_producto TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_producto TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_producto_presentacion TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_update_producto_presentacion TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_delete_producto_presentacion TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_compra TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_detalle_compra TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_crear_pedido TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_insert_detalle_pedido TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_actualizar_estado_pedido TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_registrar_pago TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_repostero_preparar_pedido TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_repostero_marcar_entregado TO 'role_admin'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_repostero_marcar_anulado TO 'role_admin'@'localhost';

-- ----------------------------
-- Cajero: procs y funciones que usa el rol de caja
-- ----------------------------
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_insert_cliente TO 'role_cajero'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_actu_cliente TO 'role_cajero'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_find_cliente TO 'role_cajero'@'localhost';

GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_crear_pedido TO 'role_cajero'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_insert_detalle_pedido TO 'role_cajero'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_actualizar_estado_pedido TO 'role_cajero'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_cajero_registrar_pago TO 'role_cajero'@'localhost';

-- ----------------------------
-- Repostero: procs de cambio de estado y validacion de stock
-- ----------------------------
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_repostero_preparar_pedido TO 'role_repostero'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_repostero_marcar_entregado TO 'role_repostero'@'localhost';
GRANT EXECUTE ON PROCEDURE ReposteriaDB.pas_repostero_marcar_anulado TO 'role_repostero'@'localhost';
