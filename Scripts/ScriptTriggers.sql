USE ReposteriaDB;

-- =============================================================
-- Triggers de consistencia (stock y pedidos)
-- =============================================================

-- Ajustar stock al registrar compras
DROP TRIGGER IF EXISTS trg_detalle_compra_ai;
DELIMITER %%
CREATE TRIGGER trg_detalle_compra_ai
AFTER INSERT ON DetalleCompra
FOR EACH ROW
BEGIN
    UPDATE Ingrediente
    SET ing_stock = ing_stock + NEW.dco_can
    WHERE ing_id = NEW.ing_id;
END %%
DELIMITER ;

DROP TRIGGER IF EXISTS trg_detalle_compra_au;
DELIMITER %%
CREATE TRIGGER trg_detalle_compra_au
AFTER UPDATE ON DetalleCompra
FOR EACH ROW
BEGIN
    -- Si cambia el ingrediente, revertir el anterior y sumar el nuevo
    IF NEW.ing_id <> OLD.ing_id THEN
        UPDATE Ingrediente SET ing_stock = ing_stock - OLD.dco_can WHERE ing_id = OLD.ing_id;
        UPDATE Ingrediente SET ing_stock = ing_stock + NEW.dco_can WHERE ing_id = NEW.ing_id;
    ELSE
        UPDATE Ingrediente
        SET ing_stock = ing_stock + (NEW.dco_can - OLD.dco_can)
        WHERE ing_id = NEW.ing_id;
    END IF;
END %%
DELIMITER ;

DROP TRIGGER IF EXISTS trg_detalle_compra_ad;
DELIMITER %%
CREATE TRIGGER trg_detalle_compra_ad
AFTER DELETE ON DetalleCompra
FOR EACH ROW
BEGIN
    UPDATE Ingrediente
    SET ing_stock = ing_stock - OLD.dco_can
    WHERE ing_id = OLD.ing_id;
END %%
DELIMITER ;

-- Validar stock antes de marcar un pedido como Preparado
DROP TRIGGER IF EXISTS trg_pedido_check_stock;
DELIMITER %%
CREATE TRIGGER trg_pedido_check_stock
BEFORE UPDATE ON Pedido
FOR EACH ROW
BEGIN
    DECLARE v_faltantes INT DEFAULT 0;
    IF NEW.ped_est = 'Preparado' AND OLD.ped_est <> 'Preparado' THEN
        SELECT COUNT(*)
        INTO v_faltantes
        FROM vw_repostero_requerimientos_pedido
        WHERE ped_id = OLD.ped_id
          AND cantidad_requerida > ing_stock;

        IF v_faltantes > 0 THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Stock insuficiente para preparar el pedido';
        END IF;
    END IF;
END %%
DELIMITER ;

-- Descontar/recuperar stock al cambiar estado de pedido
DROP TRIGGER IF EXISTS trg_pedido_update_stock;
DELIMITER %%
CREATE TRIGGER trg_pedido_update_stock
AFTER UPDATE ON Pedido
FOR EACH ROW
BEGIN
    -- Descontar cuando pasa a Preparado
    IF NEW.ped_est = 'Preparado' AND OLD.ped_est <> 'Preparado' THEN
        UPDATE Ingrediente i
        JOIN vw_repostero_requerimientos_pedido r ON i.ing_id = r.ing_id AND r.ped_id = NEW.ped_id
        SET i.ing_stock = i.ing_stock - r.cantidad_requerida;
    END IF;

    -- Devolver stock si un pedido preparado se anula
    IF OLD.ped_est = 'Preparado' AND NEW.ped_est = 'Anulado' THEN
        UPDATE Ingrediente i
        JOIN vw_repostero_requerimientos_pedido r ON i.ing_id = r.ing_id AND r.ped_id = NEW.ped_id
        SET i.ing_stock = i.ing_stock + r.cantidad_requerida;
    END IF;
END %%
DELIMITER ;
