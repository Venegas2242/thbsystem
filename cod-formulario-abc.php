<?php
/*
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
*/
/**
 * Description of class
 *
 * @author tyrodeveloper
 */

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", "1");
date_default_timezone_set("America/Mexico_City");

spl_autoload_register(function( $NombreClase ) {
    require_once $NombreClase . '.php';
});

class Productos {

    /*
    public $idproveedor = 0;
    public $nombrecomercial = "";
    public $rfc = "";
    public $telefono = 0;
    public $correo = 0;*/
    
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
        $query = $cnn->prepare("call proc_ProveedorBuscar (?)");
        $query->bind_param("s", $textoBuscar);
        $query->execute();
        $producto = new Productos(); //Variable
        $query->bind_result(
                $idproveedor, $nombrecomercial, $rfc, $telefono, $correo
        );
        while ($query->fetch()) {
            $producto = new Productos();
            $producto->idproveedor = $idproveedor;
            $producto->nombrecomercial = $nombrecomercial;
            $producto->rfc = $rfc;
            $producto->telefono = $telefono;
            $producto->correo = $correo;
            array_push($retorno, $producto);
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
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acci�n.");
        $query = $cnn->prepare("call proc_ProveedorGrabar (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        //$query->bind_param("issdd", $this->idproveedor, $this->codigo_barras, $this->nombre_producto, $this->stock, $this->precio_venta);
        $query->bind_param("isssiiissssiiisss",$this->idproveedor, $this->nombrecomercial, $this->nombrecomun, $this->direccion,$this->idciudad, $this->idestado, $this->idpais, $this->rfc, $this->telefono, $this->correo,$this->web, $this->credito, $this->saldo, $this->diascredito, $this->idbanco, $this->cuenta, $this->clabe);
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        }
        //Verificar si se obtubieron resultados
        if ($query->num_rows != 0) {
            $query->bind_result($this->idproveedor);
            if ($query->fetch()) {
                if (is_null($this->idproveedor)) {
                    $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acci�n. El error se desconoce.");
                } else {
                    $retorno = $this->ArrayMessage("1", "El producto ha sido grabado correctamente.");
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
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acci�n.");
        $query = $cnn->prepare("call proc_ProveedorEliminar (?)");
        $query->bind_param("i", $idProveedor);
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        }
        //Verificar si se obtubieron resultados
        if ($query->num_rows != 0) {
            $query->bind_result($this->idproveedor);
            if ($query->fetch()) {
                if (is_null($this->idproveedor)) {
                    $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acci�n. El error se desconoce.");
                } else {
                    $retorno = $this->ArrayMessage("1", "El producto ha sido eliminado.");
                }
            }
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }


    function ObtenerEstados() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL get_Estados()");
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


    function ObtenerCiudad() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL get_Ciudades()");
        $query->execute();
        $query->bind_result($idciudad, $nombre);
        while ($query->fetch()) {
            $pais = array("idciudad" => $idciudad, "nombre" => $nombre);
            array_push($retorno, $pais);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }
}

/*
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
*/

if (isset($_GET["functionToCall"]) && !empty($_GET["functionToCall"])) {
    $functionToCall = $_GET["functionToCall"];
    $json_data = json_decode(file_get_contents('php://input'));
    switch ($functionToCall) {
        case "buscar_producto":
            $producto = new Productos();
            echo json_encode($producto->Buscar(utf8_decode($json_data->textoBuscar)));
            break;

        case "grabar_producto":
            $producto = new Productos();
            /*
            $producto->id_producto = $json_data->id_producto;
            $producto->codigo_barras = $json_data->codigo_barras;
            $producto->nombre_producto = $json_data->nombre_producto;
            $producto->stock = $json_data->stock;
            $producto->precio_venta = $json_data->precio_venta;*/

            $producto->idproveedor  = $json_data->idproveedor;
            $producto->nombrecomercial  = $json_data->nombrecomercial;
            $producto->nombrecomun  = $json_data->nombrecomun;
            $producto->direccion  = $json_data->direccion;
            $producto->idciudad  = $json_data->idciudad;
            $producto->idestado  = $json_data->idestado;
            $producto->idpais  = $json_data->idpais;
            $producto->rfc  = $json_data->rfc;
            $producto->telefono  = $json_data->telefono;
            $producto->correo  = $json_data->correo;
            $producto->web  = $json_data->web;
            $producto->credito  = $json_data->credito;
            $producto->saldo  = $json_data->saldo;
            $producto->diascredito  = $json_data->diascredito;
            $producto->idbanco  = $json_data->idbanco;
            $producto->cuenta  = $json_data->cuenta;
            $producto->clabe  = $json_data->clabe;

            
            echo json_encode($producto->Grabar());
            break;

        case "eliminar_producto":
            $producto = new Productos();
            echo json_encode($producto->Eliminar($json_data->idproveedor));
            break;
    }
}