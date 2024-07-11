<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", "1");
date_default_timezone_set("America/Mexico_City");

spl_autoload_register(function($NombreClase) {
    require_once $NombreClase . '.php';
});

class Proveedores {
    public $nombrecomercial = "";
    public $nombrecomun = "";
    public $direccion = "";
    public $rfc = "";
    public $telefono = "";
    public $correo = "";
    public $web = "";
    public $credito = 0.0;
    public $saldo = 0.0;
    public $diascredito = 0;
    public $banco = "";
    public $cuenta = "";
    public $clabe = "";

    function BuscarInfo($idpais, $idestado, $idciudad) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("call GetProveedores(?, ?, ?)");
        $query->bind_param("iii", $idpais, $idestado, $idciudad);
        $query->execute();
        $query->bind_result($nombrefiscal, $nombrecomercial, $direccion, $rfc, $telefono, $correo, $web, $credito, $saldo, $diascredito, $nombrebanco, $cuenta, $clabe);
        while ($query->fetch()) {
            $proveedor = array(
                "nombrecomercial" => $nombrefiscal,
                "nombrecomun" => $nombrecomercial,
                "direccion" => $direccion,
                "rfc" => $rfc,
                "telefono" => $telefono,
                "correo" => $correo,
                "web" => $web,
                "credito" => $credito,
                "saldo" => $saldo,
                "diascredito" => $diascredito,
                "banco" => $nombrebanco,
                "cuenta" => $cuenta,
                "clabe" => $clabe
            );
            array_push($retorno, $proveedor);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }
}

class Ubicacion {
    public $idpais = 0;
    public $nombre_pais = "";
    public $idestado = 0;
    public $nombre_estado = "";
    public $idciudad = 0;
    public $nombre_ciudad = "";

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

    // Crear la instancia de Ubicacion aquí
    $ubicacion = new Ubicacion();

    switch ($functionToCall) {
        case "obtener_paises":
            $paises = $ubicacion->ObtenerPaises();
            echo json_encode($paises);
            break;

        case "obtener_estados":
            $estados = $ubicacion->ObtenerEstados($json_data->idpais);
            echo json_encode($estados);
            break;

        case "obtener_ciudades":
            $ciudades = $ubicacion->ObtenerCiudades($json_data->idestado);
            echo json_encode($ciudades);
            break;

        case "info_proveedor":
            $proveedor = new Proveedores();
            echo json_encode($proveedor->BuscarInfo($json_data->idpais, $json_data->idestado, $json_data->idciudad));
            break;
    }
}
?>