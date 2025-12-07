-- Script Procedimientos almacenados
-- Admin

-- Tabla Cliente
-- 1. Insertar nuevo cliente
DROP PROCEDURE IF EXISTS pas_insert_cliente;
DELIMITER %%
CREATE PROCEDURE pas_insert_cliente (
	cli_cedula BIGINT , 
    cli_nom VARCHAR(50),
    cli_apellido VARCHAR(50),
    cli_tel VARCHAR(10),
    cli_dir VARCHAR(100)
)
BEGIN 
	START TRANSACTION;
    INSERT INTO Cliente VALUES (cli_cedula, cli_nom, cli_apellido, cli_tel, cli_dir);
    
    COMMIT;
END %%
DELIMITER ;

-- 2. Actualizar cliente
DROP PROCEDURE IF EXISTS pas_actu_cliente;
DELIMITER %%
CREATE PROCEDURE pas_actu_cliente (
	cli_cedula BIGINT , 
    cli_nom VARCHAR(50),
    cli_apellido VARCHAR(50),
    cli_tel VARCHAR(10),
    cli_dir VARCHAR(100)
)
BEGIN 
	START TRANSACTION;
    UPDATE Cliente c
		SET c.cli_nom = cli_nom,
            c.cli_apellido = cli_apellido,
            c.cli_tel = cli_tel,
            c.cli_dir = cli_dir
		WHERE c.cli_cedula = cli_cedula;
    COMMIT;
END %%
DELIMITER ;

-- 3. Encontrar cliente por cédula
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

-- 4. Eliminar cliente
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

-- 5. Buscar clientes por nombre o cédula
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


-- Buscar ingredientes por nombre
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