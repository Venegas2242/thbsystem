<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", "1");
date_default_timezone_set("America/Mexico_City");

//spl_autoload_register(function($NombreClase) {
//require_once '../' . $NombreClase . '.php';
require_once '../Connection.php';
//});

class Ubicaciones
{
    public $idciudad = 0;
    public $idestado = 0;
    public $idpais = 0;
    public $nombreciudad = "";
    public $nombreestado = "";
    public $nombrepais = "";

    // Método para generar mensajes de respuesta
    private function ArrayMessage($status, $message)
    {
        return array('status' => $status, 'message' => $message);
    }

    function ObtenerPaises()
    {
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

    function ObtenerEstados($idpais)
    {
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

    function ObtenerCiudades($idestado)
    {
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

    function AgregarPais($pais_nuevo)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_AgregarPais(?)");
        $query->bind_param("s", $pais_nuevo);
        $query->execute();
        $query->store_result();
        if ($query->affected_rows == 0) {
            if (mysqli_stmt_error($query) != "") {
                $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
            } else {
                $retorno = $this->ArrayMessage("0", "El país ya está registrado");
            }
        } else {
            $retorno = $this->ArrayMessage("1", "País agregado exitosamente");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function AgregarEstado($idpais, $pais_nuevo)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_AgregarEstado(?,?)");
        $query->bind_param("is", $idpais, $pais_nuevo);
        $query->execute();
        $query->store_result();
        if ($query->affected_rows == 0) {
            if (mysqli_stmt_error($query) != "") {
                $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
            } else {
                $retorno = $this->ArrayMessage("0", "El estado ya está registrado");
            }
        } else {
            $retorno = $this->ArrayMessage("1", "Estado agregado exitosamente");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function AgregarCiudad($idestado, $ciudad_nueva)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_AgregarCiudad(?,?)");
        $query->bind_param("is", $idestado, $ciudad_nueva);
        $query->execute();
        $query->store_result();
        if ($query->affected_rows == 0) {
            if (mysqli_stmt_error($query) != "") {
                $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
            } else {
                $retorno = $this->ArrayMessage("0", "La ciudad ya está registrada");
            }
        } else {
            $retorno = $this->ArrayMessage("1", "Ciudad agregada exitosamente");
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
        case "obtener_paises":
            $ubicacion = new Ubicaciones();
            echo json_encode($ubicacion->ObtenerPaises());
            break;

        case "obtener_estados":
            $ubicacion = new Ubicaciones();
            echo json_encode($ubicacion->ObtenerEstados($json_data->idpais));
            break;

        case "obtener_ciudades":
            $ubicacion = new Ubicaciones();
            echo json_encode($ubicacion->ObtenerCiudades($json_data->idestado));
            break;

        case "registrar_pais":
            $ubicacion = new Ubicaciones();
            //$json_data = json_decode(file_get_contents('php://input'), true); // Asegúrate de que la deserialización es correcta
            echo json_encode($ubicacion->AgregarPais($json_data->pais_nuevo)); // Accede como array asociativo
            break;

        case "registrar_estado":
            $ubicacion = new Ubicaciones();
            echo json_encode($ubicacion->AgregarEstado($json_data->idpais, $json_data->estado_nuevo)); // Accede como array asociativo
            break;

        case "registrar_ciudad":
            $ubicacion = new Ubicaciones();
            echo json_encode($ubicacion->AgregarCiudad($json_data->idestado, $json_data->ciudad_nueva)); // Accede como array asociativo
            break;
    }
}
