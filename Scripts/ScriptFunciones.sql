USE ReposteriaDB;

-- Script Funciones
-- Admin 

-- 1. Calcular num pedidos entregados hoy
DROP FUNCTION IF EXISTS fn_admin_num_ped_entregados;
DELIMITER %%
CREATE FUNCTION fn_admin_num_ped_entregados ()
RETURNS INT DETERMINISTIC
	BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total
    FROM Pedido 
    WHERE ped_est = 'Entregado' AND ped_fec = CURDATE();
    RETURN total;
    END %%
DELIMITER ;

-- 2.Calcular el numero de pedidos activos
DROP FUNCTION IF EXISTS fn_admin_num_ped_activos;
DELIMITER %%
CREATE FUNCTION fn_admin_num_ped_activos ()
RETURNS INT DETERMINISTIC 
	BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total
    FROM Pedido
    WHERE ped_est = 'Preparado';
    RETURN total;
    END %%
DELIMITER ;

-- 3. Calcular el numero de productos
DROP FUNCTION IF EXISTS fn_admin_num_productos;
DELIMITER %%
CREATE FUNCTION fn_admin_num_productos ()
RETURNS INT DETERMINISTIC 
	BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total
    FROM Producto;
    RETURN total;
    END %%
DELIMITER ;

-- 4. Calcular el numero de empleados
DROP FUNCTION IF EXISTS fn_admin_num_empleados;
DELIMITER %%
CREATE FUNCTION fn_admin_num_empleados ()
RETURNS INT DETERMINISTIC 
	BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total
    FROM Empleado;
    RETURN total;
    END %%
DELIMITER ;
