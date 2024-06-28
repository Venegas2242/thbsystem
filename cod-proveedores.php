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
    public $idestado = 0;
    public $idpais = 0;
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

if (isset($_GET["functionToCall"]) && !empty($_GET["functionToCall"])) {
    $functionToCall = $_GET["functionToCall"];
    $json_data = json_decode(file_get_contents('php://input'));
    switch ($functionToCall) {
        case "buscar_proveedor":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->Buscar(utf8_decode($json_data->textoBuscar)));
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