-- SECCIÓN 1: Creación de tablas
DROP DATABASE `thb`;
create schema if not exists thb default character set latin1 collate latin1_general_ci;
use thb;

-- Tabla entidad
CREATE TABLE IF NOT EXISTS `cat_entidad` (
  `identidad` int NOT NULL AUTO_INCREMENT COMMENT 'clave del proveedor/cliente',
  `nombrefiscal` varchar(200) NOT NULL COMMENT 'Nombre fiscal del proveedor/cliente',
  `nombrecomun` varchar(200) NOT NULL COMMENT 'Nombre comercial del proveedor/cliente',
  `direccion` varchar(160) DEFAULT NULL COMMENT 'Direccion fiscal del proveedor/cliente',
  `idciudad` int NOT NULL COMMENT 'Id de la ciudad del proveedor/cliente',
  `idestado` int NOT NULL COMMENT 'Id del estado del proveedor/cliente',
  `idpais` int NOT NULL COMMENT 'Id del pais del proveedor/cliente',
  `rfc` varchar(17) DEFAULT NULL COMMENT 'RFC del proveedor/cliente',
  `telefono` varchar(40) DEFAULT NULL COMMENT 'Telefono del proveedor/cliente',
  `correo` varchar(100) DEFAULT NULL COMMENT 'Correo electronico del proveedor/cliente',
  `web` varchar(100) DEFAULT NULL COMMENT 'Pagina web del proveedor/cliente',
  `credito` double NOT NULL COMMENT 'Credito autorizado',
  `saldo` double NOT NULL COMMENT 'Saldo del cliente',
  `diascredito` int NOT NULL COMMENT 'Dias de credito',
  `idbanco` varchar(30) NOT NULL COMMENT 'Banco para realizar pagos',
  `cuenta` varchar(20) DEFAULT NULL COMMENT 'Numero de cuenta',
  `clabe` varchar(25) DEFAULT NULL COMMENT 'Cuenta clabe para transferencias',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para proveedores/clientes activos y False para cancelados.',
  `tipo` varchar(20) NOT NULL DEFAULT 'Proveedor' COMMENT 'Elegir si es Proveedor o Cliente',
  CONSTRAINT pk_productos PRIMARY KEY (identidad),
  CONSTRAINT uq_productos_rfc UNIQUE (rfc)
);

-- Tabla entidad Contactos
CREATE TABLE IF NOT EXISTS `cat_entidadcontactos` (
  `identidadcontactos` int NOT NULL AUTO_INCREMENT COMMENT 'clave del contacto',
  `identidad` int NOT NULL COMMENT 'clave del proveedor/contacto',
  `contacto` varchar(150) DEFAULT NULL COMMENT 'Nombre del contacto',
  `telefono` varchar(40) DEFAULT NULL COMMENT 'Telefono',
  `celular` varchar(40) DEFAULT NULL COMMENT 'Celular',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email',
  `comentarios` varchar(250) DEFAULT NULL COMMENT 'Comentarios',
  `activo` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`identidadcontactos`)
);

-- Tabla País
CREATE TABLE IF NOT EXISTS `cat_pais` (
  `idpais` int NOT NULL AUTO_INCREMENT COMMENT 'clave del pais',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre del pais',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para paises activos y False para cancelados.',
  CONSTRAINT pk_pais PRIMARY KEY (idpais)
);

-- Tabla Estado
CREATE TABLE IF NOT EXISTS `cat_estado` (
  `idestado` int NOT NULL AUTO_INCREMENT COMMENT 'clave del estado',
  `idpais` int NOT NULL COMMENT 'clave del pais al que pertenece el estado',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre del estado',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para estados activos y False para cancelados.',
  CONSTRAINT pk_estado PRIMARY KEY (idestado)
);

-- Tabla Ciudad
CREATE TABLE IF NOT EXISTS `cat_ciudad` (
  `idciudad` int NOT NULL AUTO_INCREMENT COMMENT 'clave de la ciudad',
  `idestado` int NOT NULL COMMENT 'clave del estado al que pertenece la ciudad',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre de la ciudad',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para estados activos y False para cancelados.',
  CONSTRAINT pk_ciudad PRIMARY KEY (idciudad)
);

-- Tabla Bancos
CREATE TABLE IF NOT EXISTS `cat_bancos` (
  `idbanco` int NOT NULL AUTO_INCREMENT COMMENT 'clave del banco',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre del banco',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para bancos activos y False para cancelados.',
  CONSTRAINT pk_bancos PRIMARY KEY (idbanco)
);

-- Tabla Usuario
CREATE TABLE IF NOT EXISTS `cat_usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `Activo` tinyint(1) DEFAULT '1',
  CONSTRAINT pk_usuario PRIMARY KEY (idusuario)
);

-- Definición de la tabla cat_producto
CREATE TABLE cat_producto (
  idproducto int NOT NULL AUTO_INCREMENT COMMENT 'Clave del producto.',
  codigo varchar(20) DEFAULT NULL,
  descripcion varchar(150) DEFAULT NULL COMMENT 'Descripcion del producto.',
  ubicacion varchar(20) DEFAULT NULL COMMENT 'Ubicacion del producto en almacen.',
  costo double DEFAULT 0 COMMENT 'Costo del producto.',
  codigobarras varchar(25) DEFAULT NULL COMMENT 'Codigo de barras del producto.',
  idunidad int NOT NULL COMMENT 'Unidad del producto.',
  idgrupoproducto int NOT NULL COMMENT 'Grupo del producto.',
  idproveedor int NOT NULL COMMENT 'Proveedor principal que surte el producto.',
  idtipoproducto int NOT NULL DEFAULT 1 COMMENT '1 producto, 2 servicio, 3 ensamble',
  activo TINYINT(1) DEFAULT 1 COMMENT 'True para productos activos.',
  inventariado TINYINT(1) DEFAULT 0,
  PRIMARY KEY (idproducto)
);

-- Definición de la tabla cat_tipoproducto
CREATE TABLE cat_tipoproducto (
    idtipoproducto int NOT NULL AUTO_INCREMENT COMMENT 'Clave del tipo de producto',
    descripcion varchar(150) DEFAULT NULL COMMENT 'Descripcion del tipo de producto.',
    activo BOOLEAN DEFAULT 1 COMMENT 'True para tipos activos.',
    PRIMARY KEY (idtipoproducto)
);

-- Definición de la tabla cat_grupoproducto
CREATE TABLE cat_grupoproducto (
  idgrupoproducto int NOT NULL AUTO_INCREMENT COMMENT 'Clave del grupo de producto.',
  descripcion varchar(150) DEFAULT NULL COMMENT 'Descripcion del grupo de producto.',
  activo BOOLEAN DEFAULT 1 COMMENT 'True para grupos activos.',
  PRIMARY KEY (idgrupoproducto)
);

-- Definición de la tabla cat_unidades
CREATE TABLE cat_unidades (
  idunidad int NOT NULL AUTO_INCREMENT COMMENT 'Clave de unidad.',
  descripcion varchar(150) DEFAULT NULL COMMENT 'Nombre de la unidad.',
  activo BOOLEAN DEFAULT 1 COMMENT 'True para unidades activas.',
  PRIMARY KEY (idunidad)
);

-- Definición de la tabla invinventario
CREATE TABLE invinventario (
  idinventario int NOT NULL AUTO_INCREMENT COMMENT 'Clave del inventario.',
  idproducto int DEFAULT NULL COMMENT 'Producto.',
  existencia double DEFAULT '0' COMMENT 'Cantidad existente.',
  solicitado double DEFAULT '0' COMMENT 'Cantidad solicitada.',
  comprometido double DEFAULT '0' COMMENT 'Cantidad comprometida.',
  stockminimo double DEFAULT '0' COMMENT 'Stock mínimo.',
  stockmaximo double DEFAULT '0' COMMENT 'Stock máximo.',
  disponible double DEFAULT '0' COMMENT 'Cantidad disponible.',
  PRIMARY KEY (idinventario)
);


-- SECCIÓN 2: Inserción de datos de prueba

-- Insertar datos en la tabla entidad
-- Insertar más entidades
insert into cat_entidad(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe,tipo)
values('HERRAMIENTAS Y MATERIALES, S.A. DE C.V.','HERRAMIENTAS Y MATERIALES','AV. REVOLUCIÓN 123, COL. CENTRO','10','4','1','HYM123456789','5551234567','contacto@herramientas.com','www.herramientas.com','50000','10000','30','2','12345678','876543210987654321','Cliente');
insert into cat_entidad(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('PLÁSTICOS DEL NORTE, S.A. DE C.V.','PLÁSTICOS DEL NORTE','CALLE INDUSTRIAL 456, ZONA INDUSTRIAL','15','15','1','PDN987654321','5557654321','ventas@plasticosnorte.com','www.plasticosnorte.com','30000','5000','45','3','87654321','123456789012345678');
insert into cat_entidad(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe,tipo)
values('ALIMENTOS NATURALES, S.A. DE C.V.','ALIMENTOS NATURALES','AV. LA SALUD 789, COL. VERDE','30','30','1','AN123456789','5559876543','info@alimentosnaturales.com','www.alimentosnaturales.com','60000','15000','60','1','23456789','210987654321098765','Cliente');
insert into cat_entidad(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('TECNOLOGÍA AVANZADA, S.A. DE C.V.','TECNOLOGÍA AVANZADA','BLVD. TECNOLÓGICO 321, PARQUE TECNOLÓGICO','22','22','1','TA987654321','5556543210','soporte@tecnologiaavanzada.com','www.tecnologiaavanzada.com','40000','20000','90','4','56789012','432109876543210987');
insert into cat_entidad(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('CONSTRUCCIONES MODERNAS, S.A. DE C.V.','CONSTRUCCIONES MODERNAS','CALLE OBRAS 987, COL. CONSTRUCCIÓN','25','25','1','CM123456789','5554321098','contacto@construccionesmodernas.com','www.construccionesmodernas.com','70000','25000','120','5','89012345','678901234567890123');
insert into cat_entidad(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('SERVICIOS INTEGRALES, S.A. DE C.V.','SERVICIOS INTEGRALES','AV. PRINCIPAL 111, COL. COMERCIAL','28','28','1','SI987654321','5553210987','contacto@serviciosintegrales.com','www.serviciosintegrales.com','20000','10000','30','6','90123456','987654321098765432');
insert into cat_entidad(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('ELECTRODOMÉSTICOS DE CALIDAD, S.A. DE C.V.','ELECTRODOMÉSTICOS DE CALIDAD','CALLE ELECTRÓNICA 654, PARQUE INDUSTRIAL','31','31','1','EC123456789','5552109876','ventas@electrodomesticoscalidad.com','www.electrodomesticoscalidad.com','80000','50000','60','7','23456789','109876543210987654');

-- Insertar contactos para el proveedor 1
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (1, 'Contacto 4', '4623080337', '4622080336', 'contacto_4@correo.com', 'Contacto 4 de proveedor 1');
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (1, 'Contacto 5', '4625550990', '4625550984', 'contacto_5@correo.com', 'Contacto 5 de proveedor 1');
-- Insertar contactos para el proveedor 2
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (2, 'Contacto 6', '4625431091', '4625431093', 'contacto_6@correo.com', 'Contacto 2 de proveedor 2');
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (2, 'Contacto 7', '4625431094', '4625431095', 'contacto_7@correo.com', 'Contacto 3 de proveedor 2');
-- Insertar contactos para el proveedor 3
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (3, 'Contacto 8', '4625431096', '4625431097', 'contacto_8@correo.com', 'Contacto 1 de proveedor 3');
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (3, 'Contacto 9', '4625431098', '4625431099', 'contacto_9@correo.com', 'Contacto 2 de proveedor 3');
-- Insertar contactos para el proveedor 4
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (4, 'Contacto 10', '4625431100', '4625431101', 'contacto_10@correo.com', 'Contacto 1 de proveedor 4');
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (4, 'Contacto 11', '4625431102', '4625431103', 'contacto_11@correo.com', 'Contacto 2 de proveedor 4');
-- Insertar contactos para el proveedor 5
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (5, 'Contacto 12', '4625431104', '4625431105', 'contacto_12@correo.com', 'Contacto 1 de proveedor 5');
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (5, 'Contacto 13', '4625431106', '4625431107', 'contacto_13@correo.com', 'Contacto 2 de proveedor 5');
-- Insertar contactos para el proveedor 6
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (6, 'Contacto 14', '4625431108', '4625431109', 'contacto_14@correo.com', 'Contacto 1 de proveedor 6');
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (6, 'Contacto 15', '4625431110', '4625431111', 'contacto_15@correo.com', 'Contacto 2 de proveedor 6');
-- Insertar contactos para el proveedor 7
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (7, 'Contacto 16', '4625431112', '4625431113', 'contacto_16@correo.com', 'Contacto 1 de proveedor 7');
insert into cat_entidadcontactos(identidad, contacto, telefono, celular, email, comentarios) 
values (7, 'Contacto 17', '4625431114', '4625431115', 'contacto_17@correo.com', 'Contacto 2 de proveedor 7');

-- Insertar datos en la tabla País
insert into cat_pais (nombre) values ('México');

-- Insertar datos en la tabla Estado
insert into cat_estado (idpais, nombre) values (1, 'Aguascalientes');
insert into cat_estado (idpais, nombre) values (1, 'Baja California');
insert into cat_estado (idpais, nombre) values (1, 'Baja California Sur');
insert into cat_estado (idpais, nombre) values (1, 'Campeche');
insert into cat_estado (idpais, nombre) values (1, 'Coahuila de Zaragoza');
insert into cat_estado (idpais, nombre) values (1, 'Colima');
insert into cat_estado (idpais, nombre) values (1, 'Chiapas');
insert into cat_estado (idpais, nombre) values (1, 'Chihuahua');
insert into cat_estado (idpais, nombre) values (1, 'Distrito Federal');
insert into cat_estado (idpais, nombre) values (1, 'Durango');
insert into cat_estado (idpais, nombre) values (1, 'Guanajuato');
insert into cat_estado (idpais, nombre) values (1, 'Guerrero');
insert into cat_estado (idpais, nombre) values (1, 'Hidalgo');
insert into cat_estado (idpais, nombre) values (1, 'Jalisco');
insert into cat_estado (idpais, nombre) values (1, 'México');
insert into cat_estado (idpais, nombre) values (1, 'Michoacán de Ocampo');
insert into cat_estado (idpais, nombre) values (1, 'Morelos');
insert into cat_estado (idpais, nombre) values (1, 'Nayarit');
insert into cat_estado (idpais, nombre) values (1, 'Nuevo León');
insert into cat_estado (idpais, nombre) values (1, 'Oaxaca');
insert into cat_estado (idpais, nombre) values (1, 'Puebla');
insert into cat_estado (idpais, nombre) values (1, 'Querétaro');
insert into cat_estado (idpais, nombre) values (1, 'Quintana Roo');
insert into cat_estado (idpais, nombre) values (1, 'San Luis Potosí');
insert into cat_estado (idpais, nombre) values (1, 'Sinaloa');
insert into cat_estado (idpais, nombre) values (1, 'Sonora');
insert into cat_estado (idpais, nombre) values (1, 'Tabasco');
insert into cat_estado (idpais, nombre) values (1, 'Tamaulipas');
insert into cat_estado (idpais, nombre) values (1, 'Tlaxcala');
insert into cat_estado (idpais, nombre) values (1, 'Veracruz de Ignacio de la Llave');
insert into cat_estado (idpais, nombre) values (1, 'Yucatán');
insert into cat_estado (idpais, nombre) values (1, 'Zacatecas');

-- Insertar datos en la tabla Ciudad
-- Insertar ciudades para el estado de Aguascalientes
insert into cat_ciudad (idestado, nombre) values (1, 'Calvillo');
insert into cat_ciudad (idestado, nombre) values (1, 'Jesús María');
insert into cat_ciudad (idestado, nombre) values (1, 'Rincón de Romos');
-- Insertar ciudades para el estado de Baja California
insert into cat_ciudad (idestado, nombre) values (2, 'Tecate');
insert into cat_ciudad (idestado, nombre) values (2, 'Playas de Rosarito');
insert into cat_ciudad (idestado, nombre) values (2, 'San Quintín');
-- Insertar ciudades para el estado de Baja California Sur
insert into cat_ciudad (idestado, nombre) values (3, 'Loreto');
insert into cat_ciudad (idestado, nombre) values (3, 'Mulegé');
insert into cat_ciudad (idestado, nombre) values (3, 'Santa Rosalía');
-- Insertar ciudades para el estado de Campeche
insert into cat_ciudad (idestado, nombre) values (4, 'Escárcega');
insert into cat_ciudad (idestado, nombre) values (4, 'Calkiní');
insert into cat_ciudad (idestado, nombre) values (4, 'Palizada');
-- Insertar ciudades para el estado de Coahuila de Zaragoza
insert into cat_ciudad (idestado, nombre) values (5, 'Piedras Negras');
insert into cat_ciudad (idestado, nombre) values (5, 'Ramos Arizpe');
insert into cat_ciudad (idestado, nombre) values (5, 'Frontera');
-- Insertar ciudades para el estado de Colima
insert into cat_ciudad (idestado, nombre) values (6, 'Villa de Álvarez');
insert into cat_ciudad (idestado, nombre) values (6, 'Armería');
insert into cat_ciudad (idestado, nombre) values (6, 'Coquimatlán');
-- Insertar ciudades para el estado de Chiapas
insert into cat_ciudad (idestado, nombre) values (7, 'Comitán');
insert into cat_ciudad (idestado, nombre) values (7, 'Palenque');
insert into cat_ciudad (idestado, nombre) values (7, 'Villaflores');
-- Insertar ciudades para el estado de Chihuahua
insert into cat_ciudad (idestado, nombre) values (8, 'Parral');
insert into cat_ciudad (idestado, nombre) values (8, 'Cuauhtémoc');
insert into cat_ciudad (idestado, nombre) values (8, 'Nuevo Casas Grandes');
-- Insertar ciudades para el estado de Ciudad de México (Distrito Federal)
insert into cat_ciudad (idestado, nombre) values (9, 'Álvaro Obregón');
insert into cat_ciudad (idestado, nombre) values (9, 'Coyoacán');
insert into cat_ciudad (idestado, nombre) values (9, 'Tlalpan');
-- Insertar ciudades para el estado de Durango
insert into cat_ciudad (idestado, nombre) values (10, 'Vicente Guerrero');
insert into cat_ciudad (idestado, nombre) values (10, 'Santiago Papasquiaro');
insert into cat_ciudad (idestado, nombre) values (10, 'Poanas');
-- Insertar ciudades para el estado de Guanajuato
insert into cat_ciudad (idestado, nombre) values (11, 'San Miguel de Allende');
insert into cat_ciudad (idestado, nombre) values (11, 'Dolores Hidalgo');
insert into cat_ciudad (idestado, nombre) values (11, 'Salamanca');
insert into cat_ciudad (idestado, nombre) values (11, 'Irapuato');
insert into cat_ciudad (idestado, nombre) values (11, 'León');
insert into cat_ciudad (idestado, nombre) values (11, 'Celaya');
-- Insertar ciudades para el estado de Guerrero
insert into cat_ciudad (idestado, nombre) values (12, 'Iguala');
insert into cat_ciudad (idestado, nombre) values (12, 'Taxco');
insert into cat_ciudad (idestado, nombre) values (12, 'Zumpango del Río');
-- Insertar ciudades para el estado de Hidalgo
insert into cat_ciudad (idestado, nombre) values (13, 'Tizayuca');
insert into cat_ciudad (idestado, nombre) values (13, 'Tula de Allende');
insert into cat_ciudad (idestado, nombre) values (13, 'Ixmiquilpan');
-- Insertar ciudades para el estado de Jalisco
insert into cat_ciudad (idestado, nombre) values (14, 'Tonalá');
insert into cat_ciudad (idestado, nombre) values (14, 'Puerto Vallarta');
insert into cat_ciudad (idestado, nombre) values (14, 'Lagos de Moreno');
-- Insertar ciudades para el estado de México
insert into cat_ciudad (idestado, nombre) values (15, 'Tlalnepantla');
insert into cat_ciudad (idestado, nombre) values (15, 'Chimalhuacán');
insert into cat_ciudad (idestado, nombre) values (15, 'Ixtapaluca');
-- Insertar ciudades para el estado de Michoacán de Ocampo
insert into cat_ciudad (idestado, nombre) values (16, 'La Piedad');
insert into cat_ciudad (idestado, nombre) values (16, 'Apatzingán');
insert into cat_ciudad (idestado, nombre) values (16, 'Pátzcuaro');
-- Insertar ciudades para el estado de Morelos
insert into cat_ciudad (idestado, nombre) values (17, 'Temixco');
insert into cat_ciudad (idestado, nombre) values (17, 'Yecapixtla');
insert into cat_ciudad (idestado, nombre) values (17, 'Tepoztlán');
-- Insertar ciudades para el estado de Nayarit
insert into cat_ciudad (idestado, nombre) values (18, 'Tepic');
insert into cat_ciudad (idestado, nombre) values (18, 'Xalisco');
insert into cat_ciudad (idestado, nombre) values (18, 'Compostela');
-- Insertar ciudades para el estado de Nuevo León
insert into cat_ciudad (idestado, nombre) values (19, 'San Pedro Garza García');
insert into cat_ciudad (idestado, nombre) values (19, 'Santa Catarina');
insert into cat_ciudad (idestado, nombre) values (19, 'San Nicolás de los Garza');
-- Insertar ciudades para el estado de Oaxaca
insert into cat_ciudad (idestado, nombre) values (20, 'Huajuapan de León');
insert into cat_ciudad (idestado, nombre) values (20, 'Tehuantepec');
insert into cat_ciudad (idestado, nombre) values (20, 'San Juan Bautista Tuxtepec');
-- Insertar ciudades para el estado de Puebla
insert into cat_ciudad (idestado, nombre) values (21, 'Tehuacán');
insert into cat_ciudad (idestado, nombre) values (21, 'Atlixco');
insert into cat_ciudad (idestado, nombre) values (21, 'San Martín Texmelucan');
-- Insertar ciudades para el estado de Querétaro
insert into cat_ciudad (idestado, nombre) values (22, 'San Juan del Río');
insert into cat_ciudad (idestado, nombre) values (22, 'El Marqués');
insert into cat_ciudad (idestado, nombre) values (22, 'Tequisquiapan');
-- Insertar ciudades para el estado de Quintana Roo
insert into cat_ciudad (idestado, nombre) values (23, 'Tulum');
insert into cat_ciudad (idestado, nombre) values (23, 'Cozumel');
insert into cat_ciudad (idestado, nombre) values (23, 'Felipe Carrillo Puerto');
-- Insertar ciudades para el estado de San Luis Potosí
insert into cat_ciudad (idestado, nombre) values (24, 'Matehuala');
insert into cat_ciudad (idestado, nombre) values (24, 'Ciudad Valles');
insert into cat_ciudad (idestado, nombre) values (24, 'Rioverde');
-- Insertar ciudades para el estado de Sinaloa
insert into cat_ciudad (idestado, nombre) values (25, 'Guasave');
insert into cat_ciudad (idestado, nombre) values (25, 'Navolato');
insert into cat_ciudad (idestado, nombre) values (25, 'Escuinapa');
-- Insertar ciudades para el estado de Sonora
insert into cat_ciudad (idestado, nombre) values (26, 'Navojoa');
insert into cat_ciudad (idestado, nombre) values (26, 'Guaymas');
insert into cat_ciudad (idestado, nombre) values (26, 'San Luis Río Colorado');
-- Insertar ciudades para el estado de Tabasco
insert into cat_ciudad (idestado, nombre) values (27, 'Cárdenas');
insert into cat_ciudad (idestado, nombre) values (27, 'Macuspana');
insert into cat_ciudad (idestado, nombre) values (27, 'Huimanguillo');
-- Insertar ciudades para el estado de Tamaulipas
insert into cat_ciudad (idestado, nombre) values (28, 'Reynosa');
insert into cat_ciudad (idestado, nombre) values (28, 'Matamoros');
insert into cat_ciudad (idestado, nombre) values (28, 'Ciudad Madero');
-- Insertar ciudades para el estado de Tlaxcala
insert into cat_ciudad (idestado, nombre) values (29, 'Chiautempan');
insert into cat_ciudad (idestado, nombre) values (29, 'Zacatelco');
insert into cat_ciudad (idestado, nombre) values (29, 'San Pablo del Monte');
-- Insertar ciudades para el estado de Veracruz de Ignacio de la Llave
insert into cat_ciudad (idestado, nombre) values (30, 'Poza Rica');
insert into cat_ciudad (idestado, nombre) values (30, 'Córdoba');
insert into cat_ciudad (idestado, nombre) values (30, 'Orizaba');
-- Insertar ciudades para el estado de Yucatán
insert into cat_ciudad (idestado, nombre) values (31, 'Progreso');
insert into cat_ciudad (idestado, nombre) values (31, 'Motul');
insert into cat_ciudad (idestado, nombre) values (31, 'Kanasín');
-- Insertar ciudades para el estado de Zacatecas
insert into cat_ciudad (idestado, nombre) values (32, 'Jerez');
insert into cat_ciudad (idestado, nombre) values (32, 'Sombrerete');
insert into cat_ciudad (idestado, nombre) values (32, 'Río Grande');

-- Insertar datos en la tabla Bancos
insert into cat_bancos (nombre) values ('Banamex');
insert into cat_bancos (nombre) values ('BBVA Bancomer');
insert into cat_bancos (nombre) values ('Santander');
insert into cat_bancos (nombre) values ('HSBC');
insert into cat_bancos (nombre) values ('Banco del Bajío');
insert into cat_bancos (nombre) values ('Inbursa');
insert into cat_bancos (nombre) values ('Scotiabank');

-- Insertar datos en la tabla Usuario
insert into `cat_usuario` (`usuario`, `contrasenia`) values ('AVENEGAS', SHA2('admin', 256));
insert into `cat_usuario` (`usuario`, `contrasenia`) values ('DVENEGAS', SHA2('admin', 256));

-- Datos de prueba para cat_grupoproducto
INSERT INTO cat_grupoproducto (descripcion, activo) VALUES ('Grupo 1', 1);
INSERT INTO cat_grupoproducto (descripcion, activo) VALUES ('Grupo 2', 1);
INSERT INTO cat_grupoproducto (descripcion, activo) VALUES ('Grupo 3', 1);

-- Datos de prueba para cat_unidades
INSERT INTO cat_unidades (descripcion, activo) VALUES ('mm', 1); -- milímetro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('cm', 1); -- centímetro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('m', 1); -- metro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('km', 1); -- kilómetro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('mg', 1); -- miligramo
INSERT INTO cat_unidades (descripcion, activo) VALUES ('g', 1); -- gramo
INSERT INTO cat_unidades (descripcion, activo) VALUES ('kg', 1); -- kilogramo
INSERT INTO cat_unidades (descripcion, activo) VALUES ('t', 1); -- tonelada
INSERT INTO cat_unidades (descripcion, activo) VALUES ('ml', 1); -- mililitro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('cl', 1); -- centilitro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('dl', 1); -- decilitro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('l', 1); -- litro
INSERT INTO cat_unidades (descripcion, activo) VALUES ('m³', 1); -- metro cúbico
INSERT INTO cat_unidades (descripcion, activo) VALUES ('s', 1); -- segundo
INSERT INTO cat_unidades (descripcion, activo) VALUES ('min', 1); -- minuto
INSERT INTO cat_unidades (descripcion, activo) VALUES ('h', 1); -- hora
INSERT INTO cat_unidades (descripcion, activo) VALUES ('d', 1); -- día
INSERT INTO cat_unidades (descripcion, activo) VALUES ('°C', 1); -- grado Celsius
INSERT INTO cat_unidades (descripcion, activo) VALUES ('K', 1); -- kelvin
INSERT INTO cat_unidades (descripcion, activo) VALUES ('J', 1); -- julio
INSERT INTO cat_unidades (descripcion, activo) VALUES ('kJ', 1); -- kilojulio
INSERT INTO cat_unidades (descripcion, activo) VALUES ('N', 1); -- newton
INSERT INTO cat_unidades (descripcion, activo) VALUES ('Pa', 1); -- pascal
INSERT INTO cat_unidades (descripcion, activo) VALUES ('kPa', 1); -- kilopascal
INSERT INTO cat_unidades (descripcion, activo) VALUES ('bar', 1); -- bar
INSERT INTO cat_unidades (descripcion, activo) VALUES ('m/s', 1); -- metros por segundo
INSERT INTO cat_unidades (descripcion, activo) VALUES ('km/h', 1); -- kilómetros por hora
INSERT INTO cat_unidades (descripcion, activo) VALUES ('mm²', 1); -- milímetro cuadrado
INSERT INTO cat_unidades (descripcion, activo) VALUES ('cm²', 1); -- centímetro cuadrado
INSERT INTO cat_unidades (descripcion, activo) VALUES ('m²', 1); -- metro cuadrado
INSERT INTO cat_unidades (descripcion, activo) VALUES ('km²', 1); -- kilómetro cuadrado
INSERT INTO cat_unidades (descripcion, activo) VALUES ('cc', 1); -- centímetro cúbico
INSERT INTO cat_unidades (descripcion, activo) VALUES ('gal', 1); -- galón

-- Datos de prueba para cat_tipoproducto
INSERT INTO cat_tipoproducto (descripcion) VALUES ('Producto');
INSERT INTO cat_tipoproducto (descripcion) VALUES ('Servicio');
INSERT INTO cat_tipoproducto (descripcion) VALUES ('Ensamble');

-- Datos de prueba para cat_producto
INSERT INTO cat_producto (codigo, descripcion, ubicacion, costo, codigobarras, idunidad, idgrupoproducto, idproveedor, idtipoproducto, activo, inventariado)
VALUES ('P001', 'Producto 1', 'A1', 10.0, '123456789012', 1, 1, 2, 1, 1, 1);

INSERT INTO cat_producto (codigo, descripcion, ubicacion, costo, codigobarras, idunidad, idgrupoproducto, idproveedor, idtipoproducto, activo, inventariado)
VALUES ('P002', 'Producto 2', 'A2', 15.0, '123456789013', 2, 2, 4, 1, 1, 1);

INSERT INTO cat_producto (codigo, descripcion, ubicacion, costo, codigobarras, idunidad, idgrupoproducto, idproveedor, idtipoproducto, activo, inventariado)
VALUES ('P003', 'Producto 3', 'A3', 20.0, '123456789014', 3, 3, 6, 1, 1, 1);

-- Datos de prueba para invinventario
INSERT INTO invinventario (idproducto, existencia, solicitado, comprometido, stockminimo, stockmaximo, disponible)
VALUES (1, 100, 10, 5, 20, 200, 85);

INSERT INTO invinventario (idproducto, existencia, solicitado, comprometido, stockminimo, stockmaximo, disponible)
VALUES (2, 150, 15, 10, 25, 250, 125);

INSERT INTO invinventario (idproducto, existencia, solicitado, comprometido, stockminimo, stockmaximo, disponible)
VALUES (3, 200, 20, 15, 30, 300, 165);


-- SECCIÓN 3: Procedimientos almacenados

DELIMITER //

-- Procedimiento para agregar contacto
CREATE PROCEDURE `proc_AgregarContactoEntidad` (
    IN p_identidad INT,
    IN p_contacto VARCHAR(255),
    IN p_telefono VARCHAR(255),
    IN p_celular VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_comentarios TEXT
)
BEGIN
    INSERT INTO cat_entidadcontactos (identidad, contacto, telefono, celular, email, comentarios)
    VALUES (
        p_identidad,
        p_contacto,
        p_telefono,
        p_celular,
        p_email,
        p_comentarios
    );
END //

-- Procedimiento para eliminar contacto
CREATE PROCEDURE `proc_EliminarContactoEntidad` (
    IN p_identidadcontactos INT
)
BEGIN
    UPDATE `cat_entidadcontactos`
    SET `activo` = 0
    WHERE `identidadcontactos` = p_identidadcontactos;
END //

-- Procedimiento para editar contacto
CREATE PROCEDURE `proc_EditarContactoEntidad` (
    IN p_idcontacto INT,
    IN p_contacto VARCHAR(255),
    IN p_telefono VARCHAR(255),
    IN p_celular VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_comentarios TEXT
)
BEGIN
    UPDATE `cat_entidadcontactos`
    SET
        `contacto` = p_contacto,
        `telefono` = p_telefono,
        `celular` = p_celular,
        `email` = p_email,
        `comentarios` = p_comentarios
    WHERE `identidadcontactos` = p_idcontacto;
END //

-- Procedimiento para listar contactos de un entidad
CREATE PROCEDURE `proc_ContactosEntidad` (
    IN id_entidad INT
)
BEGIN
    SELECT identidadcontactos, contacto, telefono, celular, email, comentarios
    FROM cat_entidadcontactos
    WHERE identidad = id_entidad AND activo = 1;
END //

-- Procedimiento para buscar entidad
CREATE PROCEDURE `proc_EntidadBuscar` (
    IN prmTextoBuscar NVARCHAR(200)
)
BEGIN
    SELECT p.identidad, p.nombrefiscal, p.rfc, p.telefono, p.correo, p.tipo
    FROM cat_entidad p
    WHERE CONCAT(p.nombrefiscal, ' ', p.nombrecomun) LIKE CONCAT('%', prmTextoBuscar, '%') AND p.activo = 1;
END //

-- Procedimiento para grabar entidad
CREATE PROCEDURE `proc_EntidadGrabar` (
    IN prmidentidad INT,
    IN prmnombrefiscal VARCHAR(200),
    IN prmnombrecomun VARCHAR(200),
    IN prmdireccion VARCHAR(160),
    IN prmidciudad INT,
    IN prmidestado INT,
    IN prmidpais INT,
    IN prmrfc VARCHAR(17),
    IN prmtelefono VARCHAR(40),
    IN prmcorreo VARCHAR(100),
    IN prmweb VARCHAR(80),
    IN prmcredito DOUBLE,
    IN prmsaldo DOUBLE,
    IN prmdiascredito INT,
    IN prmidbanco VARCHAR(30),
    IN prmcuenta VARCHAR(20),
    IN prmclabe VARCHAR(25),
    IN prmtipo VARCHAR(20)
)
BEGIN
    IF (prmidentidad = 0) THEN
        BEGIN
            IF EXISTS (SELECT 1 FROM cat_entidad WHERE rfc = prmrfc) THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ya existe otro entidad con el mismo RFC';
            END IF;
            /* Insertar registro */
            INSERT INTO cat_entidad (nombrefiscal, nombrecomun, direccion, idciudad, idestado, idpais, rfc, telefono, correo, web, credito, saldo, diascredito, idbanco, cuenta, clabe, tipo)
            VALUES (prmnombrefiscal, prmnombrecomun, prmdireccion, prmidciudad, prmidestado, prmidpais, prmrfc, prmtelefono, prmcorreo, prmweb, prmcredito, prmsaldo, prmdiascredito, prmidbanco, prmcuenta, prmclabe, prmtipo);
            /* Obtener Id generado */
            SET prmidentidad = LAST_INSERT_ID();
        END;
    ELSE
        BEGIN
            IF EXISTS (SELECT 1 FROM cat_entidad WHERE rfc = prmrfc AND identidad <> prmidentidad) THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ya existe otro entidad con el mismo RFC';
            END IF;
            UPDATE cat_entidad SET
                nombrefiscal = prmnombrefiscal,
                nombrecomun = prmnombrecomun,
                direccion = prmdireccion,
                idciudad = prmidciudad,
                idestado = prmidestado,
                idpais = prmidpais,
                rfc = prmrfc,
                telefono = prmtelefono,
                correo = prmcorreo,
                web = prmweb,
                credito = prmcredito,
                saldo = prmsaldo,
                diascredito = prmdiascredito,
                idbanco = prmidbanco,
                cuenta = prmcuenta,
                clabe = prmclabe,
                tipo = prmtipo
            WHERE identidad = prmidentidad;
        END;
    END IF;
    SELECT prmidentidad;
END //

-- Procedimiento para eliminar entidad
CREATE PROCEDURE `proc_EntidadEliminar` (
    IN prmidentidad INT
)
BEGIN
    UPDATE cat_entidad
    SET activo = 0
    WHERE identidad = prmidentidad;
    SELECT prmidentidad;
END //

-- Procedimiento para obtener información del entidad
CREATE PROCEDURE `proc_EntidadInfo` (
    IN id_entidad INT
)
BEGIN
<<<<<<< HEAD
    SELECT nombrefiscal, nombrecomun, direccion, p.idciudad, ci.nombre AS Ciudad, es.idestado, es.nombre AS Estado, pa.idpais, pa.nombre AS Pais, rfc, telefono, correo, web, credito, saldo, diascredito, b.idbanco, b.nombre AS Banco, cuenta, clabe, tipo FROM cat_entidad p JOIN cat_pais pa ON p.idpais = pa.idpais JOIN cat_estado es ON p.idestado = es.idestado JOIN cat_ciudad ci ON p.idciudad = ci.idciudad JOIN cat_bancos b ON p.idbanco = b.idbanco WHERE p.identidad = id_entidad;
=======
    SSELECT nombrefiscal, nombrecomun, direccion, p.idciudad, ci.nombre AS Ciudad, es.idestado, es.nombre AS Estado, pa.idpais, pa.nombre AS Pais, rfc, telefono, correo, web, credito, saldo, diascredito, b.idbanco, b.nombre AS Banco, cuenta, clabe, tipo FROM cat_entidad p JOIN cat_pais pa ON p.idpais = pa.idpais JOIN cat_estado es ON p.idestado = es.idestado JOIN cat_ciudad ci ON p.idciudad = ci.idciudad JOIN cat_bancos b ON p.idbanco = b.idbanco WHERE p.identidad = id_entidad;
>>>>>>> 98e358246d0dc38c07cc036b299e97b46e3b31b5
END //

-- Procedimientos para obtener listas de países, estados y ciudades
CREATE PROCEDURE `get_Paises` ()
BEGIN
    SELECT idpais, nombre
    FROM cat_pais
    WHERE activo = 1
    ORDER BY nombre;
END //

CREATE PROCEDURE `get_Estados` (
    IN id_pais INT
)
BEGIN
    SELECT idestado, nombre
    FROM cat_estado
    WHERE activo = 1 AND idpais = id_pais
    ORDER BY nombre;
END //

CREATE PROCEDURE `get_Ciudades` (
    IN id_estado INT
)
BEGIN
    SELECT idciudad, nombre
    FROM cat_ciudad
    WHERE activo = 1 AND idestado = id_estado
    ORDER BY nombre;
END //

-- Procedimiento para obtener lista de bancos
CREATE PROCEDURE `get_Bancos` ()
BEGIN
    SELECT idbanco, nombre
    FROM cat_bancos
    WHERE activo = 1;
END //

-- Procedimiento para verificar usuario
CREATE PROCEDURE `proc_VerificarUsuario` (
    IN p_usuario VARCHAR(15),
    IN p_contrasenia VARCHAR(100)
)
BEGIN
    SELECT idusuario,
           IF(contrasenia = SHA2(p_contrasenia, 256), 1, 0) AS is_valid
    FROM cat_usuario
    WHERE usuario = p_usuario AND Activo = 1;
END //

DELIMITER ;

-- Para filtrar al generar reportes
DELIMITER //

CREATE PROCEDURE `GetEntidades` (
    IN pidpais INT,
    IN pidestado INT,
    IN pidciudad INT,
    IN ptipo VARCHAR(50) -- Cambiar a VARCHAR para aceptar 'Proveedor' o 'Cliente'
)
BEGIN
    SELECT 
        p.nombrefiscal, 
        p.nombrecomun, 
        p.direccion, 
        p.rfc, 
        p.telefono, 
        p.correo, 
        p.web, 
        p.credito, 
        p.saldo, 
        p.diascredito, 
        b.nombre AS Banco, 
        p.cuenta, 
        p.clabe,
        COALESCE(c.identidadcontactos, 0) AS identidadcontactos,
        COALESCE(c.contacto, 'Sin contactos') AS contacto,
        COALESCE(c.telefono, '') AS contacto_telefono,
        COALESCE(c.celular, '') AS contacto_celular,
        COALESCE(c.email, '') AS contacto_email,
        COALESCE(c.comentarios, '') AS contacto_comentarios
    FROM 
        cat_entidad p
    JOIN 
        cat_bancos b ON p.idbanco = b.idbanco
    LEFT JOIN 
        cat_entidadcontactos c ON p.identidad = c.identidad
    WHERE 
        (pidpais = 0 OR p.idpais = pidpais)
        AND (pidestado = 0 OR p.idestado = pidestado)
        AND (pidciudad = 0 OR p.idciudad = pidciudad)
        AND p.tipo = ptipo;
END //

DELIMITER ;

DELIMITER //

-- Procedimiento para obtener todos los usuarios
CREATE PROCEDURE proc_getUsuarios()
BEGIN
    SELECT idusuario, usuario FROM cat_usuario WHERE Activo = 1;
END //

-- Procedimiento para insertar o actualizar un usuario
CREATE PROCEDURE proc_UsuarioGrabar(
    IN p_idusuario INT,
    IN p_usuario VARCHAR(15),
    IN p_contrasena VARCHAR(100)
)
BEGIN
    IF p_idusuario = 0 THEN
        INSERT INTO cat_usuario (usuario, contrasenia) VALUES (p_usuario, SHA2(p_contrasena, 256));
    ELSE
        UPDATE cat_usuario SET usuario = p_usuario, contrasenia = SHA2(p_contrasena, 256) WHERE idusuario = p_idusuario;
    END IF;
END //

-- Procedimiento para eliminar un usuario
CREATE PROCEDURE proc_UsuarioEliminar(IN p_idusuario INT)
BEGIN
    UPDATE cat_usuario SET Activo = 0 WHERE idusuario = p_idusuario;
END //

-- Procedimiento para actualizar la contraseña de un usuario
CREATE PROCEDURE proc_ActualizarContrasena(
    IN p_idusuario INT,
    IN p_contrasena VARCHAR(100)
)
BEGIN
    UPDATE cat_usuario SET contrasenia = SHA2(p_contrasena, 256) WHERE idusuario = p_idusuario;
END //

DELIMITER ;

DELIMITER //

-- Procedimiento para obtener todos los bancos
CREATE PROCEDURE proc_getBancos()
BEGIN
    SELECT idbanco, nombre FROM cat_bancos WHERE activo = 1;
END //

-- Procedimiento para insertar o actualizar un banco
CREATE PROCEDURE proc_BancoGrabar(
    IN p_idbanco INT,
    IN p_nombre VARCHAR(200)
)
BEGIN
    IF p_idbanco = 0 THEN
        INSERT INTO cat_bancos (nombre) VALUES (p_nombre);
    ELSE
        UPDATE cat_bancos SET nombre = p_nombre WHERE idbanco = p_idbanco;
    END IF;
END //

-- Procedimiento para eliminar un banco
CREATE PROCEDURE proc_BancoEliminar(IN p_idbanco INT)
BEGIN
    UPDATE cat_bancos SET activo = 0 WHERE idbanco = p_idbanco;
END //

-- Procedimiento para actualizar un banco
CREATE PROCEDURE proc_BancoActualizar(
    IN p_idbanco INT,
    IN p_nombre VARCHAR(200)
)
BEGIN
    UPDATE cat_bancos SET nombre = p_nombre WHERE idbanco = p_idbanco;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE proc_AgregarPais(
    IN p_nombre VARCHAR(200)
)
BEGIN
    DECLARE existe INT DEFAULT 0;
    SELECT COUNT(*) INTO existe FROM cat_pais WHERE nombre = p_nombre;
    IF existe = 0 THEN
        INSERT INTO cat_pais (nombre) VALUES (p_nombre);
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El país ya está registrado';
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE proc_AgregarEstado(
    IN p_idpais INT,
    IN p_nombre VARCHAR(200)
)
BEGIN
    DECLARE existe INT DEFAULT 0;
    SELECT COUNT(*) INTO existe FROM cat_estado WHERE nombre = p_nombre AND idpais = p_idpais;
    IF existe = 0 THEN
        INSERT INTO cat_estado (idpais, nombre) VALUES (p_idpais, p_nombre);
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El estado ya está registrado en este país';
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE proc_AgregarCiudad(
    IN p_idestado INT,
    IN p_nombre VARCHAR(200)
)
BEGIN
    DECLARE existe INT DEFAULT 0;
    SELECT COUNT(*) INTO existe FROM cat_ciudad WHERE nombre = p_nombre AND idestado = p_idestado;
    IF existe = 0 THEN
        INSERT INTO cat_ciudad (idestado, nombre) VALUES (p_idestado, p_nombre);
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La ciudad ya está registrada en este estado';
    END IF;
END //
DELIMITER ;

DELIMITER //
-- Procedimiento para eliminar pais
CREATE PROCEDURE `proc_EliminarPais` (
    IN p_idpais INT
)
BEGIN
    UPDATE `cat_pais`
    SET `activo` = 0
    WHERE `idpais` = p_idpais;
END //
DELIMITER ;

DELIMITER //
-- Procedimiento para eliminar estado
CREATE PROCEDURE `proc_EliminarEstado` (
    IN p_idestado INT
)
BEGIN
    UPDATE `cat_estado`
    SET `activo` = 0
    WHERE `idestado` = p_idestado;
END //
DELIMITER ;

DELIMITER //
-- Procedimiento para eliminar ciudad
CREATE PROCEDURE `proc_EliminarCiudad` (
    IN p_idciudad INT
)
BEGIN
    UPDATE `cat_ciudad`
    SET `activo` = 0
    WHERE `idciudad` = p_idciudad;
END //
DELIMITER ;

DELIMITER //
-- Procedimiento para actualizar un pais
CREATE PROCEDURE proc_PaisActualizar(
    IN p_idpais INT,
    IN p_nombre VARCHAR(200)
)
BEGIN
    UPDATE cat_pais SET nombre = p_nombre WHERE idpais = p_idpais;
END //
DELIMITER ;

DELIMITER //
-- Procedimiento para actualizar un estado
CREATE PROCEDURE proc_EstadoActualizar(
    IN p_idestado INT,
    IN p_nombre VARCHAR(200)
)
BEGIN
    UPDATE cat_estado SET nombre = p_nombre WHERE idestado = p_idestado;
END //
DELIMITER ;

DELIMITER //
-- Procedimiento para actualizar una ciudad
CREATE PROCEDURE proc_CiudadActualizar(
    IN p_idciudad INT,
    IN p_nombre VARCHAR(200)
)
BEGIN
    UPDATE cat_ciudad SET nombre = p_nombre WHERE idciudad = p_idciudad;
END //
DELIMITER ;

DELIMITER //

CREATE PROCEDURE `proc_ProductoBuscar` (
    IN prmTextoBuscar NVARCHAR(200)
)
BEGIN
    SELECT p.idproducto, p.descripcion, p.codigo, p.ubicacion, p.costo
    FROM cat_producto p
    WHERE CONCAT(p.descripcion, ' ', p.codigo) LIKE CONCAT('%', prmTextoBuscar, '%') AND p.activo = 1;
END //

CREATE PROCEDURE obtener_productos()
BEGIN
    SELECT p.idproducto, p.codigo, p.descripcion, p.ubicacion, p.costo, p.codigobarras,
           p.idunidad, u.descripcion AS unidad, p.idgrupoproducto, g.descripcion AS grupo,
           p.idproveedor, e.nombrecomun AS proveedor, p.idtipoproducto, t.descripcion
    FROM cat_producto p
    LEFT JOIN cat_unidades u ON p.idunidad = u.idunidad
    LEFT JOIN cat_grupoproducto g ON p.idgrupoproducto = g.idgrupoproducto
    LEFT JOIN cat_entidad e ON p.idproveedor = e.identidad
    LEFT JOIN cat_tipoproducto t ON p.idtipoproducto = t.idtipoproducto
    WHERE e.tipo = 'Proveedor' AND p.activo = 1;
END //

CREATE PROCEDURE agregar_producto(
    IN p_codigo VARCHAR(20),
    IN p_descripcion VARCHAR(150),
    IN p_ubicacion VARCHAR(20),
    IN p_costo DOUBLE,
    IN p_codigobarras VARCHAR(25),
    IN p_idunidad INT,
    IN p_idgrupoproducto INT,
    IN p_idproveedor INT,
    IN p_idtipoproducto INT
)
BEGIN
    INSERT INTO cat_producto (codigo, descripcion, ubicacion, costo, codigobarras, idunidad, idgrupoproducto, idproveedor, idtipoproducto)
    VALUES (p_codigo, p_descripcion, p_ubicacion, p_costo, p_codigobarras, p_idunidad, p_idgrupoproducto, p_idproveedor, p_idtipoproducto);
END //

CREATE PROCEDURE eliminar_producto(
    IN p_idproducto INT
)
BEGIN
    UPDATE cat_producto
    SET activo = 0
    WHERE idproducto = p_idproducto;
END //

CREATE PROCEDURE actualizar_producto(
    IN p_idproducto INT,
    IN p_codigo VARCHAR(20),
    IN p_descripcion VARCHAR(150),
    IN p_ubicacion VARCHAR(20),
    IN p_costo DOUBLE,
    IN p_codigobarras VARCHAR(25),
    IN p_idunidad INT,
    IN p_idgrupoproducto INT,
    IN p_idproveedor INT,
    IN p_idtipoproducto INT
)
BEGIN
    UPDATE cat_producto
    SET
        codigo = p_codigo,
        descripcion = p_descripcion,
        ubicacion = p_ubicacion,
        costo = p_costo,
        codigobarras = p_codigobarras,
        idunidad = p_idunidad,
        idgrupoproducto = p_idgrupoproducto,
        idproveedor = p_idproveedor,
        idtipoproducto = p_idtipoproducto
    WHERE idproducto = p_idproducto;
END //

CREATE PROCEDURE obtener_unidades(IN p_idunidad INT)
BEGIN
    SELECT idunidad, descripcion 
    FROM cat_unidades 
    WHERE activo = 1
    ORDER BY 
        CASE 
            WHEN idunidad = p_idunidad THEN 0 
            ELSE 1 
        END, 
        idunidad;
END //

CREATE PROCEDURE obtener_grupos(IN p_idgrupoproducto INT)
BEGIN
    SELECT idgrupoproducto, descripcion 
    FROM cat_grupoproducto 
    WHERE activo = 1
    ORDER BY 
        CASE 
            WHEN idgrupoproducto = p_idgrupoproducto THEN 0 
            ELSE 1 
        END, 
        idgrupoproducto;
END //

CREATE PROCEDURE obtener_tipos(IN p_idtipoproducto INT)
BEGIN
    SELECT idtipoproducto, descripcion
    FROM cat_tipoproducto 
    WHERE activo = 1
    ORDER BY 
        CASE 
            WHEN idtipoproducto = p_idtipoproducto THEN 0 
            ELSE 1 
        END, 
        idtipoproducto;
END //

CREATE PROCEDURE obtener_proveedores(IN p_identidad INT)
BEGIN
    SELECT identidad, nombrecomun AS nombre
    FROM cat_entidad
    WHERE tipo = 'Proveedor' AND activo = 1
    ORDER BY 
        CASE 
            WHEN identidad = p_identidad THEN 0 
            ELSE 1 
        END, 
        identidad;
END //

CREATE PROCEDURE agregar_unidad(
    IN descripcion VARCHAR(150)
)
BEGIN
    INSERT INTO cat_unidades (descripcion, activo)
    VALUES (descripcion, 1);
END //

CREATE PROCEDURE agregar_grupo(
    IN descripcion VARCHAR(150)
)
BEGIN
    INSERT INTO cat_grupoproducto (descripcion, activo)
    VALUES (descripcion, 1);
END //

CREATE PROCEDURE agregar_tipo(
    IN descripcion VARCHAR(150)
)
BEGIN
    INSERT INTO cat_tipoproducto (descripcion, activo)
    VALUES (descripcion, 1);
END //

DELIMITER ;