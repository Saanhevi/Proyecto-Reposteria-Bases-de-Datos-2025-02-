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

