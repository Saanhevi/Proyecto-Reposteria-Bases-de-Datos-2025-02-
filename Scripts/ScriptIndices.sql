-- Creacion Indices
-- Se crean los siguientes indices debido a que se realizaran busquedas,
-- empleando procedimientos almacenados, teniendo estos atributos como condiciones 

-- Indice para el nombre del cliente
CREATE INDEX idx_cli_nom
ON Cliente(cli_nom);

-- Indice para el nombre del ingrediente
CREATE INDEX idx_ing_nom
ON Ingrediente(ing_nom);

-- Indice para la fecha del pedido
CREATE INDEX idx_ped_fec
ON Pedido(ped_fec);

-- Indice para el estado del pedido
CREATE INDEX idx_ped_est
ON Pedido(ped_est);
