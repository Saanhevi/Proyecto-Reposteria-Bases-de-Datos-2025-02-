INSERT INTO Cliente (cli_cedula, cli_nom, cli_apellido, cli_tel, cli_dir) VALUES
(1016797812, 'Laura', 'Gómez', '3105551111', 'Calle 10 #12-34'),
(1036897912, 'Carlos', 'Pérez', '3115552222', 'Carrera 45 #56-78'),
(1021243132, 'María', 'Rodríguez', '3125553333', 'Calle 5 #23-10'),
(1023126339, 'Andrés', 'Moreno', '3135554444', 'Carrera 8 #14-22'),
(1055116539, 'Sofía', 'López', '3145555555', 'Calle 33 #7-90'),
(1051351367, 'Jorge', 'Ramírez', '3151116666', 'Calle 20 #9-15'),
(1077808445, 'Natalia', 'García', '3162227777', 'Carrera 10 #34-90'),
(1078904346, 'Sebastián', 'Martínez', '3173338888', 'Av. 6 #45-67'),
(1076790905, 'Daniela', 'Ortiz', '3184449999', 'Transv. 8 #56-21'),
(1078065423, 'Felipe', 'Cano', '3195550000', 'Diagonal 12 #78-23');

INSERT INTO Empleado (emp_id,emp_nom, emp_tel) VALUES
(1016797813,'Ana Ruiz', '3154441111'),
(1066280984,'Julián Castro', '3164442222'),
(1016797832,'Diana Cárdenas', '3174443333'),
(1016797213,'Luis Vargas', '3184444444'),
(1016797223,'Camila Torres', '3194445555');

INSERT INTO Cajero (emp_id, caj_turno) VALUES
(1016797813, 'Mañana'),
(1066280984, 'Tarde');

INSERT INTO Repostero (emp_id, rep_especialidad) VALUES
(1016797832, 'Tortas frías'),
(1016797213, 'Postres al horno');

INSERT INTO Domiciliario (emp_id, dom_medTrans) VALUES
(1016797223, 'Moto');

INSERT INTO Proveedor (prov_nom, prov_tel, prov_dir) VALUES
('Provepan', '3005551010', 'Cra 12 #45-56'),
('Dulcehogar', '3015552020', 'Calle 8 #22-33'),
('Lácteos del Valle', '3025553030', 'Zona Industrial 4'),
('Sabores S.A.', '3035554040', 'Calle 15 #8-20');

INSERT INTO Ingrediente (ing_nom, ing_um, ing_stock, ing_reord) VALUES
('Harina de trigo', 'kg', 25.00, 5.00),              
('Azúcar blanca', 'kg', 20.00, 4.00),                
('Leche entera', 'L', 15.00, 3.00),                  
('Huevos', 'unidad', 120.00, 30.00),                 
('Mantequilla', 'kg', 10.00, 2.00),                  
('Chocolate en polvo', 'kg', 8.00, 2.00),            
('Gelatina sin sabor', 'unidad', 50.00, 10.00),      
('Crema de leche', 'L', 12.00, 2.00),                
('Fresas', 'kg', 6.00, 1.00),                        
('Galletas dulces', 'kg', 7.00, 1.00),               
('Cacao puro', 'kg', 5.00, 1.00),                    
('Vainilla líquida', 'L', 3.00, 1.00),               
('Queso crema', 'kg', 6.00, 1.00),                   
('Galletas de chocolate', 'kg', 8.00, 2.00),         
('Frutos rojos', 'kg', 4.00, 1.00),                  
('Glaseado de vainilla', 'kg', 4.00, 1.00),          
('Queso mascarpone', 'kg', 5.00, 1.00),              
('Galletas tipo soletilla', 'kg', 6.00, 1.00),       
('Frambuesas', 'kg', 3.00, 1.00);                    


INSERT INTO Receta (rec_nom) VALUES
('Torta de chocolate'),
('Postre de limón'),
('Cheesecake de fresa'),
('Tiramisú'),
('Mousse de chocolate'),
('Cupcakes de vainilla'),
('Postre de frutos rojos');

INSERT INTO DetalleReceta (rec_id, ing_id, dre_can) VALUES
(1, 1, 0.50),  
(1, 2, 0.30), 
(1, 4, 4.00),  
(1, 6, 0.20),  
(1, 5, 0.10),
(2, 1, 0.20),
(2, 2, 0.15),
(2, 7, 2.00),
(2, 8, 0.50),
(3, 1, 0.30),
(3, 8, 0.50),
(3, 9, 0.40),
(3, 13, 0.30),
(4, 2, 0.25),
(4, 10, 0.30),
(4, 3, 0.40),
(4, 8, 0.20),
(4, 17, 0.25),
(4, 18, 0.20),
(5, 1, 0.30),   
(5, 8, 0.30),   
(5, 2, 0.20),
(5, 6, 0.20),
(5, 12, 0.05),
(6, 1, 0.25),
(6, 2, 0.15),
(6, 4, 2.00),
(6, 5, 0.10),
(6, 16, 0.10),
(7, 13, 0.30),
(7, 8, 0.10),
(7, 15, 0.20),
(7, 17, 0.20),
(7, 19, 0.15);


INSERT INTO Producto (pro_nom, rec_id) VALUES
('Torta de chocolate', 1),
('Postre de limón', 2),
('Cheesecake de fresa', 3),
('Tiramisú', 4),
('Mousse de chocolate', 5),
('Cupcakes de vainilla', 6),
('Postre de frutos rojos', 7);

INSERT INTO Tamano (tam_nom, tam_porciones, tam_factor) VALUES
('Individual', '1 porción', 1.00),
('Pequeño', '4-6 porciones', 1.50),
('Mediano', '8-10 porciones', 2.00),
('Grande', '12-15 porciones', 3.00);

INSERT INTO ProductoPresentacion (pro_id, tam_id, prp_precio) VALUES
(1, 1, 5000),
(1, 3, 18000),
(1, 4, 25000),
(2, 1, 4500),
(2, 2, 8000),
(3, 1, 7000),
(3, 3, 20000),
(4, 1, 6000),
(4, 2, 12000),
(5, 1, 5500),
(5, 3, 17000),
(6, 1, 4000),
(6, 2, 7500),
(6, 3, 13000),
(7, 1, 6500),
(7, 2, 11000),
(7, 4, 24000);

INSERT INTO Pedido (cli_cedula, emp_id, ped_fec, ped_hora, ped_est, ped_total) VALUES
(1016797812, 1016797813, '2025-10-20', '09:30:00', 'Entregado', 25000),
(1036897912, 1066280984, '2025-10-21', '10:00:00', 'Pendiente', 32000),
(1021243132, 1016797813, '2025-10-22', '15:15:00', 'Entregado', 45000),
(1023126339, 1066280984, '2025-10-25', '11:45:00', 'Pendiente', 18000),
(1055116539, 1016797813, '2025-10-26', '14:20:00', 'Anulado', 0),
(1051351367, 1016797813, '2025-10-27', '09:10:00', 'Entregado', 30000),
(1077808445, 1016797813, '2025-10-27', '09:45:00', 'Entregado', 18000),
(1078904346, 1066280984, '2025-10-28', '10:30:00', 'Pendiente', 21000),
(1076790905, 1016797813, '2025-10-28', '11:15:00', 'Entregado', 27000),
(1078065423, 1066280984, '2025-10-29', '16:00:00', 'Pendiente', 35000),
(1016797812, 1016797813, '2025-10-29', '17:30:00', 'Entregado', 18000),
(1036897912, 1016797813, '2025-10-30', '09:00:00', 'Entregado', 27000),
(1078065423, 1016797813, '2025-10-30', '17:00:00', 'Pendiente', 25000);

INSERT INTO DetallePedido (ped_id, prp_id, dpe_can, dpe_subtotal) VALUES
(1, 1, 2, 10000),
(1, 3, 1, 15000),
(2, 4, 3, 13500),
(2, 5, 1, 8000),
(3, 6, 2, 14000),
(3, 7, 1, 20000),
(4, 8, 3, 18000),
(5, 1, 1, 5000),
(6, 9, 2, 13000),    
(6, 10, 1, 5500),    
(7, 12, 2, 15000),   
(7, 13, 1, 6500),    
(8, 6, 1, 7000),
(8, 11, 1, 4000),
(9, 7, 1, 20000),
(9, 13, 1, 6500),
(10, 8, 2, 12000),
(10, 9, 1, 6500),
(11, 10, 1, 5500),
(11, 12, 2, 15000),
(11, 13, 2, 13000),
(12, 4, 1, 4500),
(12, 6, 1, 7000),
(13, 7, 1, 20000),
(13, 1, 1, 5000);

INSERT INTO Pago (ped_id, pag_fec, pag_hora, pag_metodo) VALUES
(1, '2025-10-20', '10:00:00', 'Efectivo'),
(3, '2025-10-22', '15:30:00', 'Tarjeta'),
(6, '2025-10-27', '09:40:00', 'Efectivo'),
(7, '2025-10-27', '10:10:00', 'Transferencia'),
(9, '2025-10-28', '11:45:00', 'Tarjeta'),
(10, '2025-10-29', '16:30:00', 'Efectivo'),
(12, '2025-10-29', '17:45:00', 'Tarjeta'),
(13, '2025-10-30', '09:15:00', 'Efectivo');

INSERT INTO Compra (prov_id, com_fec, com_tot) VALUES
(1, '2025-10-15 08:30:00', 50000),
(2, '2025-10-18 09:00:00', 35000),
(3, '2025-10-19 10:30:00', 40000),
(4, '2025-10-24 09:00:00', 25000),
(1, '2025-10-26 10:30:00', 60000),
(3, '2025-10-28 08:00:00', 45000);

INSERT INTO DetalleCompra (com_id, ing_id, dco_can, dco_pre) VALUES
(1, 1, 20.00, 2500),
(1, 2, 15.00, 2200),
(2, 3, 10.00, 2000),
(2, 4, 50.00, 500),
(3, 5, 5.00, 3000),
(3, 6, 3.00, 4000),
(3, 8, 5.00, 2500),
(4, 9, 5.00, 4000),
(4, 10, 3.00, 3500),
(4, 12, 2.00, 1500),
(5, 1, 25.00, 2500),
(5, 2, 15.00, 2200),
(5, 14, 2.00, 3500),
(5, 15, 2.00, 4000),
(6, 13, 4.00, 4500),
(6, 16, 2.00, 3000),
(6, 17, 2.00, 5000),
(6, 18, 3.00, 4000),
(6, 19, 2.00, 5000);

