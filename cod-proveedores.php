<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", "1");
date_default_timezone_set("America/Mexico_City");

spl_autoload_register(function($NombreClase) {
    require_once $NombreClase . '.php';
});

class Proveedores {
    public $idproveedor = 0;
    public $nombrecomercial = "";
    public $nombrecomun = "";
    public $direccion = "";
    public $idciudad = 0;
    public $nombreciudad = "";
    public $idestado = 0;
    public $nombreestado = "";
    public $idpais = 0;
    public $nombrepais = "";
    public $rfc = "";
    public $telefono = "";
    public $correo = "";
    public $web = "";
    public $credito = 0.0;
    public $saldo = 0.0;
    public $diascredito = 0;
    public $idbanco = "";
    public $cuenta = "";
    public $clabe = "";

    function Buscar($textoBuscar) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("call proc_ProveedorBuscar(?)");
        $query->bind_param("s", $textoBuscar);
        $query->execute();
        $query->bind_result($idproveedor, $nombrecomercial, $rfc, $telefono, $correo);
        while ($query->fetch()) {
            $proveedor = new Proveedores();
            $proveedor->idproveedor = $idproveedor;
            $proveedor->nombrecomercial = $nombrecomercial;
            $proveedor->rfc = $rfc;
            $proveedor->telefono = $telefono;
            $proveedor->correo = $correo;
            array_push($retorno, $proveedor);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function BuscarInfo($id_proveedor) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("call proc_ProveedorInfo(?)");
        $query->bind_param("s", $id_proveedor);
        $query->execute();
        $query->bind_result($nombrefiscal, $nombrecomercial, $direccion, $idciudad, $nombreciudad, $idestado, $nombreestado, $idpais, $nombrepais, $rfc, $telefono, $correo, $web, $credito, $saldo, $diascredito, $idbanco, $cuenta, $clabe);
        while ($query->fetch()) {
            $proveedor = new Proveedores();
            $proveedor->idproveedor = $id_proveedor;
            $proveedor->nombrecomercial  = $nombrefiscal;
            $proveedor->nombrecomun  = $nombrecomercial;
            $proveedor->direccion  = $direccion;
            $proveedor->idciudad  = $idciudad;
            $proveedor->nombreciudad = $nombreciudad;
            $proveedor->idestado  = $idestado;
            $proveedor->nombreestado = $nombreestado;
            $proveedor->idpais  = $idpais;
            $proveedor->nombrepais = $nombrepais;
            $proveedor->rfc  = $rfc;
            $proveedor->telefono  = $telefono;
            $proveedor->correo  = $correo;
            $proveedor->web  = $web;
            $proveedor->credito  = $credito;
            $proveedor->saldo  = $saldo;
            $proveedor->diascredito  = $diascredito;
            $proveedor->idbanco  = $idbanco;
            $proveedor->cuenta  = $cuenta;
            $proveedor->clabe  = $clabe;
            array_push($retorno, $proveedor);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function ArrayMessage($status, $message) {
        $retorno = array("status" => $status, "message" => $message, "date" => date("Y-m-d H:i:s"));
        return $retorno;
    }

    function Grabar() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");
        $query = $cnn->prepare("call proc_ProveedorGrabar(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $query->bind_param("isssiiissssddisss", 
            $this->idproveedor, 
            $this->nombrecomercial, 
            $this->nombrecomun, 
            $this->direccion, 
            $this->idciudad, 
            $this->idestado, 
            $this->idpais, 
            $this->rfc, 
            $this->telefono, 
            $this->correo, 
            $this->web, 
            $this->credito, 
            $this->saldo, 
            $this->diascredito, 
            $this->idbanco, 
            $this->cuenta, 
            $this->clabe
        );
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        }
        if ($query->num_rows != 0) {
            $query->bind_result($this->idproveedor);
            if ($query->fetch()) {
                if (is_null($this->idproveedor)) {
                    $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción. El error se desconoce.");
                } else {
                    $retorno = $this->ArrayMessage("1", "El proveedor ha sido grabado correctamente.");
                }
            }
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function Eliminar($idProveedor) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");
        $query = $cnn->prepare("call proc_ProveedorEliminar(?)");
        $query->bind_param("i", $idProveedor);
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        }
        if ($query->num_rows != 0) {
            $query->bind_result($this->idproveedor);
            if ($query->fetch()) {
                if (is_null($this->idproveedor)) {
                    $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción. El error se desconoce.");
                } else {
                    $retorno = $this->ArrayMessage("1", "El proveedor ha sido eliminado.");
                }
            }
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function ObtenerPaises() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL get_Paises()");
        $query->execute();
        $query->bind_result($idpais, $nombre);
        while ($query->fetch()) {
            $pais = array("idpais" => $idpais, "nombre" => $nombre);
            array_push($retorno, $pais);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function ObtenerEstados($idpais) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL get_Estados(?)");
        $query->bind_param("i", $idpais);
        $query->execute();
        $query->bind_result($idestado, $nombre);
        while ($query->fetch()) {
            $estado = array("idestado" => $idestado, "nombre" => $nombre);
            array_push($retorno, $estado);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function ObtenerCiudades($idestado) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL get_Ciudades(?)");
        $query->bind_param("i", $idestado);
        $query->execute();
        $query->bind_result($idciudad, $nombre);
        while ($query->fetch()) {
            $ciudad = array("idciudad" => $idciudad, "nombre" => $nombre);
            array_push($retorno, $ciudad);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }
}

class Contactos {
    public $idcontacto = 0;
    public $contacto = "";
    public $telefono = "";
    public $celular = "";
    public $comentarios = "";

    function ArrayMessage($status, $message) {
        return array("status" => $status, "message" => $message, "date" => date("Y-m-d H:i:s"));
    }

    function BuscarContactos($id_proveedor) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_ContactosProveedor(?)");
        $query->bind_param("i", $id_proveedor);
        $query->execute();
        $query->bind_result($id_contacto, $contacto, $telefono, $celular, $comentarios);
        while ($query->fetch()) {
            $contacto = array("idcontacto" => $id_contacto, "contacto" => $contacto, "telefono" => $telefono, "celular" => $celular, "comentarios" => $comentarios);
            array_push($retorno, $contacto);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function AgregarContacto($id_proveedor) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_AgregarContactoProveedor(?,?,?,?,?)");
        $query->bind_param("issss", 
            $id_proveedor, 
            $this->contacto,
            $this->telefono,
            $this->celular,
            $this->comentarios);

        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        } else {
            $retorno = $this->ArrayMessage("1", "El contacto ha sido agregado correctamente.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function EliminarContacto($idproveedorcontactos) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_EliminarContactoProveedor(?)");
        $query->bind_param("i", $idproveedorcontactos);
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        } else {
            $retorno = $this->ArrayMessage("1", "El contacto ha sido marcado como inactivo.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }
    
    
    function EditarContacto($idcontacto, $contacto, $telefono, $celular, $comentarios) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_EditarContactoProveedor(?, ?, ?, ?, ?)");
        $query->bind_param("issss", 
            $idcontacto,
            $contacto,
            $telefono,
            $celular,
            $comentarios);
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        } else {
            $retorno = $this->ArrayMessage("1", "El contacto ha sido editado correctamente.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }    
}

if (isset($_GET["functionToCall"]) && !empty($_GET["functionToCall"])) {
    $functionToCall = $_GET["functionToCall"];
    $json_data = json_decode(file_get_contents('php://input'));
    switch ($functionToCall) {
        case "buscar_proveedor":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->Buscar(utf8_decode($json_data->textoBuscar)));
            break;

        case "info_proveedor":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->BuscarInfo($json_data->id_proveedor));
            break;

        case "grabar_proveedor":
            $proveedor = new Proveedores();
            $proveedor->idproveedor  = $json_data->idproveedor;
            $proveedor->nombrecomercial  = $json_data->nombrecomercial;
            $proveedor->nombrecomun  = $json_data->nombrecomun;
            $proveedor->direccion  = $json_data->direccion;
            $proveedor->idciudad  = $json_data->idciudad;
            $proveedor->idestado  = $json_data->idestado;
            $proveedor->idpais  = $json_data->idpais;
            $proveedor->rfc  = $json_data->rfc;
            $proveedor->telefono  = $json_data->telefono;
            $proveedor->correo  = $json_data->correo;
            $proveedor->web  = $json_data->web;
            $proveedor->credito  = $json_data->credito;
            $proveedor->saldo  = $json_data->saldo;
            $proveedor->diascredito  = $json_data->diascredito;
            $proveedor->idbanco  = $json_data->idbanco;
            $proveedor->cuenta  = $json_data->cuenta;
            $proveedor->clabe  = $json_data->clabe;

            echo json_encode($proveedor->Grabar());
            break;

        case "eliminar_proveedor":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->Eliminar($json_data->idproveedor));
            break;
        
        case "contactos_proveedor":
            $contacto = new Contactos();
            echo json_encode($contacto->BuscarContactos($json_data->id_proveedor));
            break;

        case "agregar_contacto":
            $contacto = new Contactos();
            $contacto->contacto  = $json_data->contacto;
            $contacto->telefono  = $json_data->telefono;
            $contacto->celular  = $json_data->celular;
            $contacto->comentarios  = $json_data->comentarios;

            echo json_encode($contacto->AgregarContacto($json_data->id_proveedor));
            break;

        case "editar_contacto":
            $contacto = new Contactos();
            echo json_encode($contacto->EditarContacto(
                $json_data->idproveedorcontactos,
                $json_data->contacto,
                $json_data->telefono,
                $json_data->celular,
                $json_data->comentarios
            ));
            break;

        case "eliminar_contacto":
            $contacto = new Contactos();
            echo json_encode($contacto->EliminarContacto(
                $json_data->idcontacto
            ));
            break;

        case "obtener_estados":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->ObtenerEstados($json_data->idpais));
            break;

        case "obtener_ciudades":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->ObtenerCiudades($json_data->idestado));
            break;

        case "obtener_paises":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->ObtenerPaises());
            break;
    }
}