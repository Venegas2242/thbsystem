create schema if not exists thb default character set latin1 collate latin1_general_ci;
use thb;

CREATE TABLE IF NOT EXISTS `cat_proveedor` (
  `idproveedor` int NOT NULL AUTO_INCREMENT COMMENT 'clave del proveedor',
  `nombrefiscal` varchar(200) NOT NULL COMMENT 'Nombre fiscal del proveedor',
  `nombrecomun` varchar(200) NOT NULL COMMENT 'Nombre fiscal del proveedor',
  `direccion` varchar(160) DEFAULT NULL COMMENT 'Direccion fiscal del proveedor',
  `idciudad` int NOT NULL COMMENT 'Idc de ciudad del proveedor',
  `idestado` int NOT NULL COMMENT 'Id del estado del proveedor',
  `idpais` int NOT NULL COMMENT 'Id del pais del cliente',
  `rfc` varchar(17) DEFAULT NULL COMMENT 'RFC del proveedor',
  `telefono` varchar(40) DEFAULT NULL COMMENT 'Telefono del proveedor',
  `correo` varchar(100) DEFAULT NULL COMMENT 'Correo electronico del proveedor',
  `web` varchar(100) DEFAULT NULL COMMENT 'Correo electronico del proveedor',
  `credito` double NOT NULL COMMENT 'Credito autorizado',
  `saldo` double NOT NULL COMMENT 'Saldo del cliente',
  `diascredito` int NOT NULL COMMENT 'Dias de credito',
  `idbanco` varchar(30) DEFAULT NULL COMMENT 'Banco para relizar pagos',
  `cuenta` varchar(20) DEFAULT NULL COMMENT 'Numero de cuenta',
  `clabe` varchar(25) DEFAULT NULL COMMENT 'Cuenta clabe para transferencias',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para proveedores activos y False para cancelados.',
  constraint pk_productos primary key(idproveedor),
  constraint uq_productos_rfc unique(rfc));


 CREATE TABLE IF NOT EXISTS`cat_proveedorcontactos` (
  `idproveedorcontactos` int NOT NULL AUTO_INCREMENT COMMENT 'clave del proveedor',
  `idproveedor` int NOT NULL COMMENT 'clave del proveedor',
  `contacto` varchar(150) DEFAULT NULL COMMENT 'Nombre comercial',
  `telefono` varchar(40) DEFAULT NULL COMMENT 'Telefono 2',
  `celular` varchar(40) DEFAULT NULL COMMENT 'Celular',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email',
  `comentarios` varchar(250) DEFAULT NULL COMMENT 'Nombre comercial', 
  `activo` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idproveedorcontactos`)
);


/*insertar datos de prueba*/
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
            values('PROVEEDOR SIN ASIGNARAVR','NA','NA','1','11','1','XAXX010101000','-','-','','0','0','0','3','129141','9912134012314561');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
            values('LORENZO GARCIA PICENO','ABASTECEDORA DE GUANTES Y EQUIPOS','HERMANOS FLORES MAGON 240  CP 36550  COL. MIGUEL HIDALGO','2','11','1','GALP730810152','1430868','ELADIA.RAMIREZ@PRODIGY.NET.MX','','0','0','0','1','234535','1209837890134791');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe) 
            values('ACEROS Y BARRAS ESPECIALES, SA DE CV','ACEROS Y BARRAS ESPECIALES, SA DE CV','BLVD. MARIANO J. GARCIA 2959  CP 36565  COL. GANADERA','1','11','1','ABE030124G88','6269009','','','20000','0','15','2','3456567','23230987345124512');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
            values('MIGUEL ANGEL MENA ZAMOREZ','ACEROS ANZA','ZARAGOZA 575  CP 36588  BARRIO DE SAN VICENTE','3','11','1','MEZM870321738','6602088','ACEROSALIADOSANZA@HOTMAIL.COM','','0','0','30','3','3456736','928179412653811');

DELIMITER //

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

DELIMITER ;


DELIMITER //

CREATE PROCEDURE `proc_EliminarContactoProveedor` (
    IN p_idproveedorcontactos INT
)
BEGIN
    UPDATE `cat_proveedorcontactos`
    SET `activo` = 0
    WHERE `idproveedorcontactos` = p_idproveedorcontactos;
END //

DELIMITER ;

DELIMITER //

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

DELIMITER ;


insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
  values (1, 'Contacto 1', '4623080336', '4622080335', 'contacto_1@correo.com', 'Contacto 1 de proveedor 1');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
  values (1, 'Contacto 2', '4625550989', '4625550983', 'contacto_2@correo.com', 'Contacto 2 de proveedor 1');
insert into cat_proveedorcontactos(idproveedor, contacto, telefono, celular, email, comentarios) 
  values (2, 'Contacto 3', '4625431090', '4625431092', 'contacto_3@correo.com', 'Contacto 1 de proveedor 2');

delimiter //
create procedure proc_ContactosProveedor
(
 id_proveedor int
)
begin
  select idproveedorcontactos, contacto, telefono, celular, comentarios
    from cat_proveedorcontactos
    where idproveedor = id_proveedor and activo = '1';
end
//
delimiter ;
  
/*mostrar datos*/
select * from cat_proveedor;
/*procedimientos almacenados*/

delimiter //
create procedure proc_ProveedorBuscar
(
 prmTextoBuscar nvarchar(200)
)
begin
 select p.idproveedor, p.nombrefiscal, p.rfc, p.telefono, p.correo
    from cat_proveedor p
    where concat(p.nombrefiscal,' ', p.nombrecomun) like concat('%', prmTextoBuscar, '%') and p.activo = '1';
end
//
delimiter ;

DELIMITER //

CREATE PROCEDURE proc_ProveedorGrabar(
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
            IF EXISTS(SELECT 1 FROM cat_proveedor WHERE rfc = prmrfc) THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ya existe otro proveedor con el mismo RFC';
            END IF;
            /* Insertar registro */
            INSERT INTO cat_proveedor(nombrefiscal, nombrecomun, direccion, idciudad, idestado, idpais, rfc, telefono, correo, web, credito, saldo, diascredito, idbanco, cuenta, clabe)
            VALUES(prmnombrefiscal, prmnombrecomun, prmdireccion, prmidciudad, prmidestado, prmidpais, prmrfc, prmtelefono, prmcorreo, prmweb, prmcredito, prmsaldo, prmdiascredito, prmidbanco, prmcuenta, prmclabe);
            /* Obtener Id generado */
            SET prmidproveedor = LAST_INSERT_ID();
        END;
    ELSE
        BEGIN
            IF EXISTS(SELECT 1 FROM cat_proveedor WHERE rfc = prmrfc AND idproveedor <> prmidproveedor) THEN
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

DELIMITER ;


drop procedure if exists proc_ProveedorEliminar;
delimiter //
create procedure proc_ProveedorEliminar
(
 prmidproveedor int
)
begin
 update cat_proveedor
    set activo = '0'
    where idproveedor=prmidproveedor;
    select prmidproveedor;
end
//
delimiter ;

CREATE TABLE IF NOT EXISTS `cat_pais` (
  `idpais` int NOT NULL AUTO_INCREMENT COMMENT 'clave del pais',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre del pais',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para paises activos y False para cancelados.',
  constraint pk_pais primary key(idpais));
CREATE TABLE IF NOT EXISTS `cat_estado` (
  `idestado` int NOT NULL AUTO_INCREMENT COMMENT 'clave del estado',
  `idpais` int NOT NULL COMMENT 'clave del pais al que pertenece el estado',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre del estado',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para estados  activos y False para cancelados.',
  constraint pk_estado primary key(idestado));
CREATE TABLE IF NOT EXISTS `cat_ciudad` (
  `idciudad` int NOT NULL AUTO_INCREMENT COMMENT 'clave de la ciudad',
  `idestado` int NOT NULL COMMENT 'clave del estado al que pertenece la ciudad',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre de la ciudad',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para estados  activos y False para cancelados.',
  constraint pk_ciudad primary key(idciudad));

/*insertar datos de prueba*/
insert into cat_pais(nombre) values('México');
insert into cat_estado(idpais,nombre) values(1,'Aguascalientes');
insert into cat_estado(idpais,nombre) values(1,'Baja California');
insert into cat_estado(idpais,nombre) values(1,'Baja California Sur');
insert into cat_estado(idpais,nombre) values(1,'Campeche');
insert into cat_estado(idpais,nombre) values(1,'Coahuila de Zaragoza');
insert into cat_estado(idpais,nombre) values(1,'Colima');
insert into cat_estado(idpais,nombre) values(1,'Chiapas');
insert into cat_estado(idpais,nombre) values(1,'Chihuahua');
insert into cat_estado(idpais,nombre) values(1,'Distrito Federal');
insert into cat_estado(idpais,nombre) values(1,'Durango');
insert into cat_estado(idpais,nombre) values(1,'Guanajuato');
insert into cat_estado(idpais,nombre) values(1,'Guerrero');
insert into cat_estado(idpais,nombre) values(1,'Hidalgo');
insert into cat_estado(idpais,nombre) values(1,'Jalisco');
insert into cat_estado(idpais,nombre) values(1,'México');
insert into cat_estado(idpais,nombre) values(1,'Michoacán de Ocampo');
insert into cat_estado(idpais,nombre) values(1,'Morelos');
insert into cat_estado(idpais,nombre) values(1,'Nayarit');
insert into cat_estado(idpais,nombre) values(1,'Nuevo León');
insert into cat_estado(idpais,nombre) values(1,'Oaxaca');
insert into cat_estado(idpais,nombre) values(1,'Puebla');
insert into cat_estado(idpais,nombre) values(1,'Querétaro');
insert into cat_estado(idpais,nombre) values(1,'Quintana Roo');
insert into cat_estado(idpais,nombre) values(1,'San Luis Potosí');
insert into cat_estado(idpais,nombre) values(1,'Sinaloa');
insert into cat_estado(idpais,nombre) values(1,'Sonora');
insert into cat_estado(idpais,nombre) values(1,'Tabasco');
insert into cat_estado(idpais,nombre) values(1,'Tamaulipas');
insert into cat_estado(idpais,nombre) values(1,'Tlaxcala');
insert into cat_estado(idpais,nombre) values(1,'Veracruz de Ignacio de la Llave');
insert into cat_estado(idpais,nombre) values(1,'Yucatán');
insert into cat_estado(idpais,nombre) values(1,'Zacatecas');
insert into cat_ciudad(idestado,nombre) values(11,'Irapuato');
insert into cat_ciudad(idestado,nombre) values(11,'León');
insert into cat_ciudad(idestado,nombre) values(11,'Celaya');

/*procedimientos almacenados*/

delimiter //
create procedure proc_PaisBuscar
(
 prmTextoBuscar nvarchar(200)
)
begin
 select p.idpais, p.nombre
    from cat_pais p
    where p.nombre like concat('%', prmTextoBuscar, '%') and p.activo = '1';
end
//
delimiter ;

delimiter //
create procedure proc_EstadoBuscar
(
 prmTextoBuscar nvarchar(200)
)
begin
 select p.idestado, p_idpais, p.nombre
    from cat_estado p
    where p.nombre like concat('%', prmTextoBuscar, '%') and p.activo = '1';
end
//
delimiter ;

delimiter //
create procedure proc_CiudadBuscar
(
 prmTextoBuscar nvarchar(200)
)
begin
 select p.idciudad, p_idestado, p.nombre
    from cat_ciudad p
    where p.nombre like concat('%', prmTextoBuscar, '%') and p.activo = '1';
end
//
delimiter ;


/*procedimientos Diego*/
DELIMITER //

CREATE PROCEDURE get_Paises()
BEGIN
    SELECT idpais, nombre 
      FROM cat_pais
      WHERE activo = 1;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE get_Estados(
  id_pais INT
)
BEGIN
    SELECT idestado, nombre 
      FROM cat_estado
      WHERE activo = 1 AND idpais = id_pais;
END
//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE get_Ciudades(
  id_estado INT
)
BEGIN
    SELECT idciudad, nombre 
      FROM cat_ciudad
      WHERE activo = 1 and idestado = id_estado;
END //

DELIMITER ;

CREATE TABLE IF NOT EXISTS `cat_bancos` (
  `idbanco` int NOT NULL AUTO_INCREMENT COMMENT 'clave del banco',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre del banco',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para bancos activos y False para cancelados.',
  constraint pk_bancos primary key(idbanco));

/*insertar datos de prueba*/
insert into cat_bancos(nombre) values('Banamex');
insert into cat_bancos(nombre) values('BBVA Bancomer ');
insert into cat_bancos(nombre) values('Santander');
insert into cat_bancos(nombre) values('HSBC');
insert into cat_bancos(nombre) values('Banco del Bajío');
insert into cat_bancos(nombre) values('Inbursa');
insert into cat_bancos(nombre) values('Scotiabank');

DELIMITER //

CREATE PROCEDURE get_Bancos()
BEGIN
    SELECT idbanco, nombre 
      FROM cat_bancos
      WHERE activo = 1;
END //

DELIMITER ;

CREATE TABLE `cat_usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `Activo` tinyint(1) DEFAULT '1',
  constraint pk_usuario primary key(idusuario));

INSERT INTO `cat_usuario` (`usuario`,`contrasenia`) values ('AVENEGAS',SHA2('admin', 256));
INSERT INTO `cat_usuario` (`usuario`,`contrasenia`) values ('DVENEGAS',SHA2('admin', 256));

DELIMITER //

CREATE PROCEDURE proc_VerificarUsuario(
    IN p_usuario VARCHAR(15),
    IN p_contrasenia VARCHAR(100)
)
BEGIN
    SELECT idusuario, 
           IF(contrasenia = SHA2(p_contrasenia, 256), 1, 0) AS is_valid
    FROM cat_usuario 
    WHERE usuario = p_usuario
      AND Activo = 1;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE proc_ProveedorInfo(
    IN id_proveedor INT
)
BEGIN
    select nombrefiscal, nombrecomun, direccion, ci.idciudad, ci.nombre Ciudad, es.idestado, es.nombre Estado, pa.idpais, pa.nombre Pais, rfc, telefono, correo, web, credito, saldo, diascredito, b.idbanco, b.nombre, cuenta, clabe 
      from cat_proveedor p, cat_pais pa, cat_estado es, cat_ciudad ci, cat_bancos b
      where p.idproveedor = id_proveedor AND p.idpais = pa.idpais AND p.idestado = es.idestado AND p.idciudad = ci.idciudad AND p.idbanco = b.idbanco;
END //

DELIMITER ;