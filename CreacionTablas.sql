DROP SCHEMA IF EXISTS ReposteriaDB;
CREATE SCHEMA ReposteriaDB;
USE ReposteriaDB;
CREATE TABLE Cliente (
    cli_cedula INT PRIMARY KEY,
    cli_nom VARCHAR(50) NOT NULL,
    cli_apellido VARCHAR(50) NOT NULL,
    cli_tel VARCHAR(10) NOT NULL,
    cli_dir VARCHAR(100)
);

CREATE TABLE Empleado (
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_nom VARCHAR(100) NOT NULL,
    emp_tel VARCHAR(10) NOT NULL
);

CREATE TABLE Cajero (
    emp_id INT PRIMARY KEY,
    caj_turno ENUM('Mañana','Tarde','Noche') NOT NULL,
    FOREIGN KEY (emp_id) REFERENCES Empleado(emp_id)
);

CREATE TABLE Repostero (
    emp_id INT PRIMARY KEY,
    rep_especialidad VARCHAR(100),
    FOREIGN KEY (emp_id) REFERENCES Empleado(emp_id)
);

CREATE TABLE Domiciliario (
	emp_id INT PRIMARY KEY,
    dom_medTrans ENUM('Bicicleta','Moto'),
	FOREIGN KEY (emp_id) REFERENCES Empleado(emp_id)
);

CREATE TABLE Proveedor (
    prov_id INT AUTO_INCREMENT PRIMARY KEY,
    prov_nom VARCHAR(100) NOT NULL,
    prov_tel VARCHAR(10) NOT NULL,
    prov_dir VARCHAR(150) NOT NULL
);

CREATE TABLE Ingrediente (
    ing_id INT AUTO_INCREMENT PRIMARY KEY,
    ing_nom VARCHAR(100) NOT NULL,
    ing_um ENUM('kg','L','unidad') NOT NULL,
    ing_stock DECIMAL(10,2) NOT NULL,
    ing_reord DECIMAL(10,2) NOT NULL
);

CREATE TABLE Receta (
    rec_id INT AUTO_INCREMENT PRIMARY KEY,
    rec_nom VARCHAR(100) NOT NULL
);

CREATE TABLE DetalleReceta (
    rec_id INT NOT NULL,
    ing_id INT NOT NULL,
    dre_can DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (rec_id, ing_id),
    FOREIGN KEY (rec_id) REFERENCES Receta(rec_id),
    FOREIGN KEY (ing_id) REFERENCES Ingrediente(ing_id)
);

CREATE TABLE Producto (
    pro_id INT AUTO_INCREMENT PRIMARY KEY,
    pro_nom VARCHAR(100) NOT NULL,
    rec_id INT NOT NULL,
    FOREIGN KEY (rec_id) REFERENCES Receta(rec_id)
);

CREATE TABLE Tamano (
    tam_id INT AUTO_INCREMENT PRIMARY KEY,
    tam_nom ENUM('Individual','Pequeño','Mediano','Grande') NOT NULL,
    tam_porciones VARCHAR(30) NOT NULL,
    tam_factor DECIMAL(5,2) NOT NULL
);

CREATE TABLE ProductoPresentacion (
    prp_id INT AUTO_INCREMENT PRIMARY KEY,
    pro_id INT NOT NULL,
    tam_id INT NOT NULL,
    prp_precio DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pro_id) REFERENCES Producto(pro_id),
    FOREIGN KEY (tam_id) REFERENCES Tamano(tam_id)
);

CREATE TABLE Pedido (
    ped_id INT AUTO_INCREMENT PRIMARY KEY,
    cli_cedula INT NOT NULL,
    emp_id INT NOT NULL,
    ped_fec DATE NOT NULL,
    ped_hora TIME NOT NULL,
    ped_est ENUM('Pendiente', 'Preparado','Entregado','Anulado') NOT NULL,
    ped_total INT NOT NULL,
    FOREIGN KEY (cli_cedula) REFERENCES Cliente(cli_cedula),
    FOREIGN KEY (emp_id) REFERENCES Cajero(emp_id)
);

CREATE TABLE DetallePedido (
    ped_id INT NOT NULL,
    prp_id INT NOT NULL,
    dpe_can INT NOT NULL,
    dpe_subtotal INT NOT NULL,
    PRIMARY KEY (ped_id, prp_id),
    FOREIGN KEY (ped_id) REFERENCES Pedido(ped_id),
    FOREIGN KEY (prp_id) REFERENCES ProductoPresentacion(prp_id)
);

CREATE TABLE Pago (
    pag_id INT AUTO_INCREMENT PRIMARY KEY,
    ped_id INT NOT NULL,
    pag_fec DATE NOT NULL,
    pag_hora TIME NOT NULL,
    pag_metodo ENUM('Efectivo','Tarjeta','Transferencia') NOT NULL,
    FOREIGN KEY (ped_id) REFERENCES Pedido(ped_id)
);

CREATE TABLE Compra (
    com_id INT AUTO_INCREMENT PRIMARY KEY,
    prov_id INT NOT NULL,
    com_fec DATETIME NOT NULL,
    com_tot INT NOT NULL,
    FOREIGN KEY (prov_id) REFERENCES Proveedor(prov_id)
);

CREATE TABLE DetalleCompra (
    com_id INT NOT NULL,
    ing_id INT NOT NULL,
    dco_can DECIMAL(10,2) NOT NULL,
    dco_pre INT NOT NULL,
    PRIMARY KEY (com_id, ing_id),
    FOREIGN KEY (com_id) REFERENCES Compra(com_id),
    FOREIGN KEY (ing_id) REFERENCES Ingrediente(ing_id)
);
