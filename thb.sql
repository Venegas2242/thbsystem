-- SECCIÓN 1: Creación de tablas

create schema if not exists thb default character set latin1 collate latin1_general_ci;
use thb;

-- Tabla Proveedor
CREATE TABLE IF NOT EXISTS `cat_proveedor` (
  `idproveedor` int NOT NULL AUTO_INCREMENT COMMENT 'clave del proveedor',
  `nombrefiscal` varchar(200) NOT NULL COMMENT 'Nombre fiscal del proveedor',
  `nombrecomun` varchar(200) NOT NULL COMMENT 'Nombre comercial del proveedor',
  `direccion` varchar(160) DEFAULT NULL COMMENT 'Direccion fiscal del proveedor',
  `idciudad` int NOT NULL COMMENT 'Id de la ciudad del proveedor',
  `idestado` int NOT NULL COMMENT 'Id del estado del proveedor',
  `idpais` int NOT NULL COMMENT 'Id del pais del proveedor',
  `rfc` varchar(17) DEFAULT NULL COMMENT 'RFC del proveedor',
  `telefono` varchar(40) DEFAULT NULL COMMENT 'Telefono del proveedor',
  `correo` varchar(100) DEFAULT NULL COMMENT 'Correo electronico del proveedor',
  `web` varchar(100) DEFAULT NULL COMMENT 'Pagina web del proveedor',
  `credito` double NOT NULL COMMENT 'Credito autorizado',
  `saldo` double NOT NULL COMMENT 'Saldo del cliente',
  `diascredito` int NOT NULL COMMENT 'Dias de credito',
  `idbanco` varchar(30) DEFAULT NULL COMMENT 'Banco para realizar pagos',
  `cuenta` varchar(20) DEFAULT NULL COMMENT 'Numero de cuenta',
  `clabe` varchar(25) DEFAULT NULL COMMENT 'Cuenta clabe para transferencias',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para proveedores activos y False para cancelados.',
  CONSTRAINT pk_productos PRIMARY KEY (idproveedor),
  CONSTRAINT uq_productos_rfc UNIQUE (rfc)
);

-- Tabla Proveedor Contactos
CREATE TABLE IF NOT EXISTS `cat_proveedorcontactos` (
  `idproveedorcontactos` int NOT NULL AUTO_INCREMENT COMMENT 'clave del proveedor',
  `idproveedor` int NOT NULL COMMENT 'clave del proveedor',
  `contacto` varchar(150) DEFAULT NULL COMMENT 'Nombre del contacto',
  `telefono` varchar(40) DEFAULT NULL COMMENT 'Telefono',
  `celular` varchar(40) DEFAULT NULL COMMENT 'Celular',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email',
  `comentarios` varchar(250) DEFAULT NULL COMMENT 'Comentarios',
  `activo` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idproveedorcontactos`)
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



-- SECCIÓN 2: Inserción de datos de prueba

-- Insertar datos en la tabla Proveedor
-- Insertar más proveedores
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('HERRAMIENTAS Y MATERIALES, S.A. DE C.V.','HERRAMIENTAS Y MATERIALES','AV. REVOLUCIÓN 123, COL. CENTRO','4','4','1','HYM123456789','5551234567','contacto@herramientas.com','www.herramientas.com','50000','10000','30','2','12345678','876543210987654321');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('PLÁSTICOS DEL NORTE, S.A. DE C.V.','PLÁSTICOS DEL NORTE','CALLE INDUSTRIAL 456, ZONA INDUSTRIAL','15','15','1','PDN987654321','5557654321','ventas@plasticosnorte.com','www.plasticosnorte.com','30000','5000','45','3','87654321','123456789012345678');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('ALIMENTOS NATURALES, S.A. DE C.V.','ALIMENTOS NATURALES','AV. LA SALUD 789, COL. VERDE','30','30','1','AN123456789','5559876543','info@alimentosnaturales.com','www.alimentosnaturales.com','60000','15000','60','1','23456789','210987654321098765');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('TECNOLOGÍA AVANZADA, S.A. DE C.V.','TECNOLOGÍA AVANZADA','BLVD. TECNOLÓGICO 321, PARQUE TECNOLÓGICO','22','22','1','TA987654321','5556543210','soporte@tecnologiaavanzada.com','www.tecnologiaavanzada.com','40000','20000','90','4','56789012','432109876543210987');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('CONSTRUCCIONES MODERNAS, S.A. DE C.V.','CONSTRUCCIONES MODERNAS','CALLE OBRAS 987, COL. CONSTRUCCIÓN','25','25','1','CM123456789','5554321098','contacto@construccionesmodernas.com','www.construccionesmodernas.com','70000','25000','120','5','89012345','678901234567890123');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('SERVICIOS INTEGRALES, S.A. DE C.V.','SERVICIOS INTEGRALES','AV. PRINCIPAL 111, COL. COMERCIAL','28','28','1','SI987654321','5553210987','contacto@serviciosintegrales.com','www.serviciosintegrales.com','20000','10000','30','6','90123456','987654321098765432');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
values('ELECTRODOMÉSTICOS DE CALIDAD, S.A. DE C.V.','ELECTRODOMÉSTICOS DE CALIDAD','CALLE ELECTRÓNICA 654, PARQUE INDUSTRIAL','31','31','1','EC123456789','5552109876','ventas@electrodomesticoscalidad.com','www.electrodomesticoscalidad.com','80000','50000','60','7','23456789','109876543210987654');

-- Insertar contactos para el proveedor 1
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (1, 'Contacto 4', '4623080337', '4622080336', 'contacto_4@correo.com', 'Contacto 4 de proveedor 1');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (1, 'Contacto 5', '4625550990', '4625550984', 'contacto_5@correo.com', 'Contacto 5 de proveedor 1');
-- Insertar contactos para el proveedor 2
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (2, 'Contacto 6', '4625431091', '4625431093', 'contacto_6@correo.com', 'Contacto 2 de proveedor 2');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (2, 'Contacto 7', '4625431094', '4625431095', 'contacto_7@correo.com', 'Contacto 3 de proveedor 2');
-- Insertar contactos para el proveedor 3
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (3, 'Contacto 8', '4625431096', '4625431097', 'contacto_8@correo.com', 'Contacto 1 de proveedor 3');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (3, 'Contacto 9', '4625431098', '4625431099', 'contacto_9@correo.com', 'Contacto 2 de proveedor 3');
-- Insertar contactos para el proveedor 4
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (4, 'Contacto 10', '4625431100', '4625431101', 'contacto_10@correo.com', 'Contacto 1 de proveedor 4');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (4, 'Contacto 11', '4625431102', '4625431103', 'contacto_11@correo.com', 'Contacto 2 de proveedor 4');
-- Insertar contactos para el proveedor 5
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (5, 'Contacto 12', '4625431104', '4625431105', 'contacto_12@correo.com', 'Contacto 1 de proveedor 5');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (5, 'Contacto 13', '4625431106', '4625431107', 'contacto_13@correo.com', 'Contacto 2 de proveedor 5');
-- Insertar contactos para el proveedor 6
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (6, 'Contacto 14', '4625431108', '4625431109', 'contacto_14@correo.com', 'Contacto 1 de proveedor 6');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (6, 'Contacto 15', '4625431110', '4625431111', 'contacto_15@correo.com', 'Contacto 2 de proveedor 6');
-- Insertar contactos para el proveedor 7
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
values (7, 'Contacto 16', '4625431112', '4625431113', 'contacto_16@correo.com', 'Contacto 1 de proveedor 7');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
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



-- SECCIÓN 3: Procedimientos almacenados

DELIMITER //

-- Procedimiento para agregar contacto
CREATE PROCEDURE `proc_AgregarContactoProveedor` (
    IN p_idproveedor INT,
    IN p_contacto VARCHAR(255),
    IN p_telefono VARCHAR(255),
    IN p_celular VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_comentarios TEXT
)
BEGIN
    INSERT INTO cat_proveedorcontactos (idproveedor, contacto, telefono, celular, email, comentarios)
    VALUES (
        p_idproveedor,
        p_contacto,
        p_telefono,
        p_celular,
        p_email,
        p_comentarios
    );
END //

-- Procedimiento para eliminar contacto
CREATE PROCEDURE `proc_EliminarContactoProveedor` (
    IN p_idproveedorcontactos INT
)
BEGIN
    UPDATE `cat_proveedorcontactos`
    SET `activo` = 0
    WHERE `idproveedorcontactos` = p_idproveedorcontactos;
END //

-- Procedimiento para editar contacto
CREATE PROCEDURE `proc_EditarContactoProveedor` (
    IN p_idcontacto INT,
    IN p_contacto VARCHAR(255),
    IN p_telefono VARCHAR(255),
    IN p_celular VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_comentarios TEXT
)
BEGIN
    UPDATE `cat_proveedorcontactos`
    SET
        `contacto` = p_contacto,
        `telefono` = p_telefono,
        `celular` = p_celular,
        `email` = p_email,
        `comentarios` = p_comentarios
    WHERE `idproveedorcontactos` = p_idcontacto;
END //

-- Procedimiento para listar contactos de un proveedor
CREATE PROCEDURE `proc_ContactosProveedor` (
    IN id_proveedor INT
)
BEGIN
    SELECT idproveedorcontactos, contacto, telefono, celular, email, comentarios
    FROM cat_proveedorcontactos
    WHERE idproveedor = id_proveedor AND activo = 1;
END //

-- Procedimiento para buscar proveedor
CREATE PROCEDURE `proc_ProveedorBuscar` (
    IN prmTextoBuscar NVARCHAR(200)
)
BEGIN
    SELECT p.idproveedor, p.nombrefiscal, p.rfc, p.telefono, p.correo
    FROM cat_proveedor p
    WHERE CONCAT(p.nombrefiscal, ' ', p.nombrecomun) LIKE CONCAT('%', prmTextoBuscar, '%') AND p.activo = 1;
END //

-- Procedimiento para grabar proveedor
CREATE PROCEDURE `proc_ProveedorGrabar` (
    IN prmidproveedor INT,
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
    IN prmclabe VARCHAR(25)
)
BEGIN
    IF (prmidproveedor = 0) THEN
        BEGIN
            IF EXISTS (SELECT 1 FROM cat_proveedor WHERE rfc = prmrfc) THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ya existe otro proveedor con el mismo RFC';
            END IF;
            /* Insertar registro */
            INSERT INTO cat_proveedor (nombrefiscal, nombrecomun, direccion, idciudad, idestado, idpais, rfc, telefono, correo, web, credito, saldo, diascredito, idbanco, cuenta, clabe)
            VALUES (prmnombrefiscal, prmnombrecomun, prmdireccion, prmidciudad, prmidestado, prmidpais, prmrfc, prmtelefono, prmcorreo, prmweb, prmcredito, prmsaldo, prmdiascredito, prmidbanco, prmcuenta, prmclabe);
            /* Obtener Id generado */
            SET prmidproveedor = LAST_INSERT_ID();
        END;
    ELSE
        BEGIN
            IF EXISTS (SELECT 1 FROM cat_proveedor WHERE rfc = prmrfc AND idproveedor <> prmidproveedor) THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ya existe otro proveedor con el mismo RFC';
            END IF;
            UPDATE cat_proveedor SET
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
                clabe = prmclabe
            WHERE idproveedor = prmidproveedor;
        END;
    END IF;
    SELECT prmidproveedor;
END //

-- Procedimiento para eliminar proveedor
CREATE PROCEDURE `proc_ProveedorEliminar` (
    IN prmidproveedor INT
)
BEGIN
    UPDATE cat_proveedor
    SET activo = 0
    WHERE idproveedor = prmidproveedor;
    SELECT prmidproveedor;
END //

-- Procedimiento para obtener información del proveedor
CREATE PROCEDURE `proc_ProveedorInfo` (
    IN id_proveedor INT
)
BEGIN
    SELECT nombrefiscal, nombrecomun, direccion, ci.idciudad, ci.nombre Ciudad, es.idestado, es.nombre Estado, pa.idpais, pa.nombre Pais, rfc, telefono, correo, web, credito, saldo, diascredito, b.idbanco, b.nombre, cuenta, clabe
    FROM cat_proveedor p
    JOIN cat_pais pa ON p.idpais = pa.idpais
    JOIN cat_estado es ON p.idestado = es.idestado
    JOIN cat_ciudad ci ON p.idciudad = ci.idciudad
    JOIN cat_bancos b ON p.idbanco = b.idbanco
    WHERE p.idproveedor = id_proveedor;
END //

-- Procedimientos para obtener listas de países, estados y ciudades
CREATE PROCEDURE `get_Paises` ()
BEGIN
    SELECT idpais, nombre
    FROM cat_pais
    WHERE activo = 1;
END //

CREATE PROCEDURE `get_Estados` (
    IN id_pais INT
)
BEGIN
    SELECT idestado, nombre
    FROM cat_estado
    WHERE activo = 1 AND idpais = id_pais;
END //

CREATE PROCEDURE `get_Ciudades` (
    IN id_estado INT
)
BEGIN
    SELECT idciudad, nombre
    FROM cat_ciudad
    WHERE activo = 1 AND idestado = id_estado;
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

-- Procedimiento para verificar usuario
CREATE PROCEDURE `GetProveedores` (
    IN pidpais INT,
    IN pidestado INT,
    IN pidciudad INT
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
        p.clabe
    FROM 
        cat_proveedor p
    JOIN 
        cat_bancos b ON p.idbanco = b.idbanco
    WHERE 
        (pidpais = 0 OR p.idpais = pidpais)
        AND (pidestado = 0 OR p.idestado = pidestado)
        AND (pidciudad = 0 OR p.idciudad = pidciudad)
        AND p.activo = 1;
END

// DELIMITER ;