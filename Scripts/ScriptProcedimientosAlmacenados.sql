USE ReposteriaDB;

-- =============================================================
--  Procedimientos almacenados de apoyo a CRUD y flujos
-- =============================================================

-- ----------------------------
-- Cliente
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_insert_cliente;
DELIMITER %%
CREATE PROCEDURE pas_insert_cliente (
    IN p_cli_cedula BIGINT,
    IN p_cli_nom VARCHAR(50),
    IN p_cli_apellido VARCHAR(50),
    IN p_cli_tel VARCHAR(10),
    IN p_cli_dir VARCHAR(100)
)
BEGIN
    INSERT INTO Cliente (cli_cedula, cli_nom, cli_apellido, cli_tel, cli_dir)
    VALUES (p_cli_cedula, p_cli_nom, p_cli_apellido, p_cli_tel, p_cli_dir);
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_actu_cliente;
DELIMITER %%
CREATE PROCEDURE pas_actu_cliente (
    IN p_cli_cedula BIGINT,
    IN p_cli_nom VARCHAR(50),
    IN p_cli_apellido VARCHAR(50),
    IN p_cli_tel VARCHAR(10),
    IN p_cli_dir VARCHAR(100)
)
BEGIN
    UPDATE Cliente
    SET cli_nom      = p_cli_nom,
        cli_apellido = p_cli_apellido,
        cli_tel      = p_cli_tel,
        cli_dir      = p_cli_dir
    WHERE cli_cedula = p_cli_cedula;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_find_cliente;
DELIMITER %%
CREATE PROCEDURE pas_find_cliente (
    IN p_cli_cedula BIGINT
)
BEGIN
    SELECT *
    FROM Cliente
    WHERE cli_cedula = p_cli_cedula;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_cliente;
DELIMITER %%
CREATE PROCEDURE pas_delete_cliente (
    IN p_cli_cedula BIGINT
)
BEGIN
    DELETE FROM Cliente
    WHERE cli_cedula = p_cli_cedula;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_admin_buscar_clientes;
DELIMITER %%
CREATE PROCEDURE pas_admin_buscar_clientes (
    IN p_search_term VARCHAR(100)
)
BEGIN
    SELECT cli_cedula, cli_nom, cli_apellido, cli_tel, cli_dir
    FROM vw_admin_clientes
    WHERE CONCAT(cli_nom, ' ', cli_apellido) LIKE CONCAT('%', p_search_term, '%')
       OR cli_cedula LIKE CONCAT('%', p_search_term, '%');
END %%
DELIMITER ;

-- ----------------------------
-- Ingrediente
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_admin_buscar_ingredientes;
DELIMITER %%
CREATE PROCEDURE pas_admin_buscar_ingredientes (
    IN p_ing_nom VARCHAR(100)
)
BEGIN
    SELECT ing_nom, ing_stock_um, ing_reord_um
    FROM vw_admin_ingredientes
    WHERE ing_nom LIKE CONCAT('%', p_ing_nom, '%');
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_insert_ingrediente;
DELIMITER %%
CREATE PROCEDURE pas_insert_ingrediente (
    IN p_ing_nom VARCHAR(100),
    IN p_ing_um ENUM('kg','L','unidad'),
    IN p_ing_stock DECIMAL(10,2),
    IN p_ing_reord DECIMAL(10,2)
)
BEGIN
    INSERT INTO Ingrediente (ing_nom, ing_um, ing_stock, ing_reord)
    VALUES (p_ing_nom, p_ing_um, p_ing_stock, p_ing_reord);
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_ingrediente;
DELIMITER %%
CREATE PROCEDURE pas_update_ingrediente (
    IN p_ing_id INT,
    IN p_ing_nom VARCHAR(100),
    IN p_ing_um ENUM('kg','L','unidad'),
    IN p_ing_stock DECIMAL(10,2),
    IN p_ing_reord DECIMAL(10,2)
)
BEGIN
    UPDATE Ingrediente
    SET ing_nom   = p_ing_nom,
        ing_um    = p_ing_um,
        ing_stock = p_ing_stock,
        ing_reord = p_ing_reord
    WHERE ing_id  = p_ing_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_ingrediente;
DELIMITER %%
CREATE PROCEDURE pas_delete_ingrediente (
    IN p_ing_id INT
)
BEGIN
    DELETE FROM Ingrediente WHERE ing_id = p_ing_id;
END %%
DELIMITER ;

-- ----------------------------
-- Proveedor
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_insert_proveedor;
DELIMITER %%
CREATE PROCEDURE pas_insert_proveedor (
    IN p_nom VARCHAR(100),
    IN p_tel VARCHAR(10),
    IN p_dir VARCHAR(150)
)
BEGIN
    INSERT INTO Proveedor (prov_nom, prov_tel, prov_dir)
    VALUES (p_nom, p_tel, p_dir);
    SELECT LAST_INSERT_ID() AS prov_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_proveedor;
DELIMITER %%
CREATE PROCEDURE pas_update_proveedor (
    IN p_id INT,
    IN p_nom VARCHAR(100),
    IN p_tel VARCHAR(10),
    IN p_dir VARCHAR(150)
)
BEGIN
    UPDATE Proveedor
    SET prov_nom = p_nom,
        prov_tel = p_tel,
        prov_dir = p_dir
    WHERE prov_id = p_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_proveedor;
DELIMITER %%
CREATE PROCEDURE pas_delete_proveedor (
    IN p_id INT
)
BEGIN
    DELETE FROM Proveedor WHERE prov_id = p_id;
END %%
DELIMITER ;

-- ----------------------------
-- Empleado y roles
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_insert_empleado;
DELIMITER %%
CREATE PROCEDURE pas_insert_empleado (
    IN p_emp_id INT,
    IN p_emp_nom VARCHAR(100),
    IN p_emp_tel VARCHAR(10)
)
BEGIN
    INSERT INTO Empleado (emp_id, emp_nom, emp_tel)
    VALUES (p_emp_id, p_emp_nom, p_emp_tel);
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_empleado;
DELIMITER %%
CREATE PROCEDURE pas_update_empleado (
    IN p_emp_id INT,
    IN p_emp_nom VARCHAR(100),
    IN p_emp_tel VARCHAR(10)
)
BEGIN
    UPDATE Empleado
    SET emp_nom = p_emp_nom,
        emp_tel = p_emp_tel
    WHERE emp_id = p_emp_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_empleado;
DELIMITER %%
CREATE PROCEDURE pas_delete_empleado (
    IN p_emp_id INT
)
BEGIN
    DELETE FROM Empleado WHERE emp_id = p_emp_id;
END %%
DELIMITER ;

-- Cajero
DROP PROCEDURE IF EXISTS pas_insert_cajero;
DELIMITER %%
CREATE PROCEDURE pas_insert_cajero (
    IN p_emp_id INT,
    IN p_turno ENUM('Manana','Tarde','Noche')
)
BEGIN
    INSERT INTO Cajero (emp_id, caj_turno) VALUES (p_emp_id, p_turno);
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_cajero;
DELIMITER %%
CREATE PROCEDURE pas_update_cajero (
    IN p_emp_id INT,
    IN p_turno ENUM('Manana','Tarde','Noche')
)
BEGIN
    UPDATE Cajero SET caj_turno = p_turno WHERE emp_id = p_emp_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_cajero;
DELIMITER %%
CREATE PROCEDURE pas_delete_cajero (
    IN p_emp_id INT
)
BEGIN
    DELETE FROM Cajero WHERE emp_id = p_emp_id;
END %%
DELIMITER ;

-- Repostero
DROP PROCEDURE IF EXISTS pas_insert_repostero;
DELIMITER %%
CREATE PROCEDURE pas_insert_repostero (
    IN p_emp_id INT,
    IN p_especialidad VARCHAR(100)
)
BEGIN
    INSERT INTO Repostero (emp_id, rep_especialidad)
    VALUES (p_emp_id, p_especialidad);
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_repostero;
DELIMITER %%
CREATE PROCEDURE pas_update_repostero (
    IN p_emp_id INT,
    IN p_especialidad VARCHAR(100)
)
BEGIN
    UPDATE Repostero
    SET rep_especialidad = p_especialidad
    WHERE emp_id = p_emp_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_repostero;
DELIMITER %%
CREATE PROCEDURE pas_delete_repostero (
    IN p_emp_id INT
)
BEGIN
    DELETE FROM Repostero WHERE emp_id = p_emp_id;
END %%
DELIMITER ;

-- ----------------------------
-- Producto / Receta
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_insert_receta;
DELIMITER %%
CREATE PROCEDURE pas_insert_receta (
    IN p_rec_nom VARCHAR(100)
)
BEGIN
    INSERT INTO Receta (rec_nom) VALUES (p_rec_nom);
    SELECT LAST_INSERT_ID() AS rec_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_receta;
DELIMITER %%
CREATE PROCEDURE pas_update_receta (
    IN p_rec_id INT,
    IN p_rec_nom VARCHAR(100)
)
BEGIN
    UPDATE Receta SET rec_nom = p_rec_nom WHERE rec_id = p_rec_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_receta;
DELIMITER %%
CREATE PROCEDURE pas_delete_receta (
    IN p_rec_id INT
)
BEGIN
    DELETE FROM DetalleReceta WHERE rec_id = p_rec_id;
    DELETE FROM Receta WHERE rec_id = p_rec_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_insert_detalle_receta;
DELIMITER %%
CREATE PROCEDURE pas_insert_detalle_receta (
    IN p_rec_id INT,
    IN p_ing_id INT,
    IN p_cantidad DECIMAL(10,2)
)
BEGIN
    REPLACE INTO DetalleReceta (rec_id, ing_id, dre_can)
    VALUES (p_rec_id, p_ing_id, p_cantidad);
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_detalle_receta;
DELIMITER %%
CREATE PROCEDURE pas_delete_detalle_receta (
    IN p_rec_id INT,
    IN p_ing_id INT
)
BEGIN
    DELETE FROM DetalleReceta WHERE rec_id = p_rec_id AND ing_id = p_ing_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_insert_producto;
DELIMITER %%
CREATE PROCEDURE pas_insert_producto (
    IN p_nom VARCHAR(100),
    IN p_rec_id INT
)
BEGIN
    INSERT INTO Producto (pro_nom, rec_id) VALUES (p_nom, p_rec_id);
    SELECT LAST_INSERT_ID() AS pro_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_producto;
DELIMITER %%
CREATE PROCEDURE pas_update_producto (
    IN p_pro_id INT,
    IN p_nom VARCHAR(100),
    IN p_rec_id INT
)
BEGIN
    UPDATE Producto SET pro_nom = p_nom, rec_id = p_rec_id WHERE pro_id = p_pro_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_producto;
DELIMITER %%
CREATE PROCEDURE pas_delete_producto (
    IN p_pro_id INT
)
BEGIN
    DELETE FROM ProductoPresentacion WHERE pro_id = p_pro_id;
    DELETE FROM Producto WHERE pro_id = p_pro_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_insert_producto_presentacion;
DELIMITER %%
CREATE PROCEDURE pas_insert_producto_presentacion (
    IN p_pro_id INT,
    IN p_tam_id INT,
    IN p_precio INT
)
BEGIN
    INSERT INTO ProductoPresentacion (pro_id, tam_id, prp_precio)
    VALUES (p_pro_id, p_tam_id, p_precio);
    SELECT LAST_INSERT_ID() AS prp_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_update_producto_presentacion;
DELIMITER %%
CREATE PROCEDURE pas_update_producto_presentacion (
    IN p_prp_id INT,
    IN p_precio INT
)
BEGIN
    UPDATE ProductoPresentacion SET prp_precio = p_precio WHERE prp_id = p_prp_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_delete_producto_presentacion;
DELIMITER %%
CREATE PROCEDURE pas_delete_producto_presentacion (
    IN p_prp_id INT
)
BEGIN
    DELETE FROM ProductoPresentacion WHERE prp_id = p_prp_id;
END %%
DELIMITER ;

-- ----------------------------
-- Compras
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_insert_compra;
DELIMITER %%
CREATE PROCEDURE pas_insert_compra (
    IN p_prov_id INT,
    IN p_fecha DATETIME,
    IN p_total INT
)
BEGIN
    INSERT INTO Compra (prov_id, com_fec, com_tot)
    VALUES (p_prov_id, p_fecha, p_total);
    SELECT LAST_INSERT_ID() AS com_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_insert_detalle_compra;
DELIMITER %%
CREATE PROCEDURE pas_insert_detalle_compra (
    IN p_com_id INT,
    IN p_ing_id INT,
    IN p_cantidad DECIMAL(10,2),
    IN p_precio INT
)
BEGIN
    INSERT INTO DetalleCompra (com_id, ing_id, dco_can, dco_pre)
    VALUES (p_com_id, p_ing_id, p_cantidad, p_precio);
END %%
DELIMITER ;

-- ----------------------------
-- Pedidos (cajero)
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_cajero_crear_pedido;
DELIMITER %%
CREATE PROCEDURE pas_cajero_crear_pedido (
    IN p_cli_cedula BIGINT,
    IN p_emp_id INT,
    IN p_total INT,
    IN p_estado ENUM('Pendiente','Preparado','Entregado','Anulado')
)
BEGIN
    INSERT INTO Pedido (cli_cedula, emp_id, ped_fec, ped_hora, ped_est, ped_total)
    VALUES (p_cli_cedula, p_emp_id, CURDATE(), CURTIME(), p_estado, p_total);
    SELECT LAST_INSERT_ID() AS ped_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_cajero_insert_detalle_pedido;
DELIMITER %%
CREATE PROCEDURE pas_cajero_insert_detalle_pedido (
    IN p_ped_id INT,
    IN p_prp_id INT,
    IN p_cantidad INT,
    IN p_subtotal INT
)
BEGIN
    REPLACE INTO DetallePedido (ped_id, prp_id, dpe_can, dpe_subtotal)
    VALUES (p_ped_id, p_prp_id, p_cantidad, p_subtotal);
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_cajero_actualizar_estado_pedido;
DELIMITER %%
CREATE PROCEDURE pas_cajero_actualizar_estado_pedido (
    IN p_ped_id INT,
    IN p_estado ENUM('Pendiente','Preparado','Entregado','Anulado')
)
BEGIN
    UPDATE Pedido SET ped_est = p_estado WHERE ped_id = p_ped_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_cajero_registrar_pago;
DELIMITER %%
CREATE PROCEDURE pas_cajero_registrar_pago (
    IN p_ped_id INT,
    IN p_metodo ENUM('Efectivo','Tarjeta','Transferencia')
)
BEGIN
    INSERT INTO Pago (ped_id, pag_fec, pag_hora, pag_metodo)
    VALUES (p_ped_id, CURDATE(), CURTIME(), p_metodo);
END %%
DELIMITER ;

-- ----------------------------
-- Repostero (validación de stock)
-- ----------------------------
DROP PROCEDURE IF EXISTS pas_repostero_preparar_pedido;
DELIMITER %%
CREATE PROCEDURE pas_repostero_preparar_pedido (
    IN p_ped_id INT
)
BEGIN
    DECLARE exit handler for sqlexception
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    -- Verificar faltantes usando la vista de requerimientos
    IF EXISTS (
        SELECT 1 FROM vw_repostero_faltantes_pedido WHERE ped_id = p_ped_id
    ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Stock insuficiente para preparar el pedido';
    END IF;

    -- Marcar pedido como preparado (el trigger descuenta stock)
    UPDATE Pedido
    SET ped_est = 'Preparado'
    WHERE ped_id = p_ped_id;

    COMMIT;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_repostero_marcar_entregado;
DELIMITER %%
CREATE PROCEDURE pas_repostero_marcar_entregado (
    IN p_ped_id INT
)
BEGIN
    UPDATE Pedido
    SET ped_est = 'Entregado'
    WHERE ped_id = p_ped_id;
END %%
DELIMITER ;

DROP PROCEDURE IF EXISTS pas_repostero_marcar_anulado;
DELIMITER %%
CREATE PROCEDURE pas_repostero_marcar_anulado (
    IN p_ped_id INT
)
BEGIN
    UPDATE Pedido
    SET ped_est = 'Anulado', ped_total = 0
    WHERE ped_id = p_ped_id;
END %%
DELIMITER ;
