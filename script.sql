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
  `comentarios` varchar(250) DEFAULT NULL COMMENT 'Nombre comercial', 
  `activo` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idproveedorcontactos`)
);


/*insertar datos de prueba*/
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
            values('PROVEEDOR SIN ASIGNARAVR','-','-','1','1','1','-','-','-','','0','0','0','1','-','-');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
            values('LORENZO GARCIA PICENO','ABASTECEDORA DE GUANTES Y EQUIPOS','HERMANOS FLORES MAGON 240  CP 36550  COL. MIGUEL HIDALGO','1','1','1','GALP730810152','1430868','ELADIA.RAMIREZ@PRODIGY.NET.MX','','0','0','0','1','-','-');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe) 
            values('ACEROS Y BARRAS ESPECIALES, SA DE CV','ACEROS Y BARRAS ESPECIALES, SA DE CV','BLVD. MARIANO J. GARCIA 2959  CP 36565  COL. GANADERA','1','1','1','ABE030124G88','6269009','','','20000','0','15','1','-','-');
insert into cat_proveedor(nombreFiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
            values('MIGUEL ANGEL MENA ZAMOREZ','ACEROS ANZA','ZARAGOZA 575  CP 36588  BARRIO DE SAN VICENTE','1','1','1','MEZM870321738','6602088','ACEROSALIADOSANZA@HOTMAIL.COM','','0','0','30','1','-','-');

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

delimiter //
create procedure proc_ProveedorGrabar
(
  prmidproveedor int,
  prmnombrefiscal varchar(200),
  prmnombrecomun varchar(200),
  prmdireccion varchar(160),
  prmidciudad int,
  prmidestado int,
  prmidpais int,
  prmrfc varchar(17),
  prmtelefono varchar(40),
  prmcorreo varchar(100),
  prmweb varchar(80),
  prmcredito double,
  prmsaldo double,
  prmdiascredito int,
  prmidbanco varchar(30),
  prmcuenta varchar(20),
  prmclabe varchar(25)
)
begin
 if (prmidproveedor = 0) then
  begin
   if exists(select 1 from cat_proveedor where rfc = prmrfc) then
    signal sqlstate '45000' set message_text = 'Ya existe otro proveedor con el mismo RFC';
   end if;
   /*Insertar registro*/
   insert into cat_proveedor(nombrefiscal,nombrecomun,direccion,idciudad,idestado,idpais,rfc,telefono,correo,web,credito,saldo,diascredito,idbanco,cuenta,clabe)
            values(prmnombrefiscal,prmnombrecomun,prmdireccion,prmidciudad,prmidestado,prmidpais,prmrfc,prmtelefono,prmcorreo,prmweb,prmcredito,prmsaldo,prmdiascredito,idbanco,prmcuenta,prmclabe);
            /*Obtener Id generado*/
            set prmidproveedor = last_insert_id();

  end;
 else
  begin
   if exists(select 1 from cat_proveedor where rfc = prmRFC and idproveedor <> prmidproveedor) then
    signal sqlstate '45000' set message_text = 'Ya existe otro proveedor con el mismo RFC';
   end if;
   update cat_proveedor set
			      nombrefiscal=prmnombrefiscal,
            nombrecomun=prmnombrecomun,
            direccion=prmdireccion,
            idciudad=prmidciudad,
            idestado=prmidestado,
            idpais=prmidpais,
            rfc=prmrfc,
            telefono=prmtelefono,
            correo=prmcorreo,
            web=prmcorreo,
            credito=prmcredito,
            saldo=prmsaldo,
            diascredito=prmdiascredito,
            idbanco=prmidbanco,
            cuenta=prmcuenta,
            clabe=prmclabe
            where idproveedor = prmidproveedor;
        end;
    end if;
    select prmidproveedor;
end;
//
delimiter ;
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
  constraint pk_productos primary key(idpais));
CREATE TABLE IF NOT EXISTS `cat_estado` (
  `idestado` int NOT NULL AUTO_INCREMENT COMMENT 'clave del estado',
  `idpais` int NOT NULL COMMENT 'clave del pais al que pertenece el estado',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre del estado',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para estados  activos y False para cancelados.',
  constraint pk_productos primary key(idestado));
CREATE TABLE IF NOT EXISTS `cat_ciudad` (
  `idciudad` int NOT NULL AUTO_INCREMENT COMMENT 'clave de la ciudad',
  `idestado` int NOT NULL COMMENT 'clave del estado al que pertenece la ciudad',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre de la ciudad',
  `activo` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'True para estados  activos y False para cancelados.',
  constraint pk_productos primary key(idciudad));

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
