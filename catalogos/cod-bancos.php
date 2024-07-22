<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", "1");
date_default_timezone_set("America/Mexico_City");

spl_autoload_register(function($NombreClase) {
    require_once '../' . $NombreClase . '.php';
});

class Bancos {
    public $idbanco = 0;
    public $nombre = "";

    function Grabar() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");

        $query = $cnn->prepare("CALL proc_BancoGrabar(?, ?)");
        $query->bind_param("is", 
            $this->idbanco, 
            $this->nombre
        );
        $query->execute();
        if ($query->errno) {
            $retorno = $this->ArrayMessage("0", $query->error);
        } else {
            $retorno = $this->ArrayMessage("1", "El banco ha sido grabado correctamente.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    private function ArrayMessage($status, $message) {
        return array('status' => $status, 'message' => $message);
    }

    function getBancos() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_getBancos()");
        $query->execute();
        $query->bind_result($idbanco, $nombre);
        while ($query->fetch()) {
            $banco = array(
                "id" => $idbanco,
                "nombre" => $nombre
            );
            array_push($retorno, $banco);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function Eliminar($idBanco) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");
        $query = $cnn->prepare("CALL proc_BancoEliminar(?)");
        $query->bind_param("i", $idBanco);
        $query->execute();
        if ($query->errno) {
            $retorno = $this->ArrayMessage("0", $query->error);
        } else {
            $retorno = $this->ArrayMessage("1", "El banco ha sido eliminado.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function Actualizar($idBanco, $nombre) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");

        $query = $cnn->prepare("CALL proc_BancoActualizar(?, ?)");
        $query->bind_param("is", $idBanco, $nombre);
        $query->execute();
        if ($query->errno) {
            $retorno = $this->ArrayMessage("0", $query->error);
        } else {
            $retorno = $this->ArrayMessage("1", "El banco ha sido actualizado.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }
}

if (isset($_GET["functionToCall"]) && !empty($_GET["functionToCall"])) {
    $functionToCall = $_GET["functionToCall"];
    $json_data = json_decode(file_get_contents('php://input'), true);
    $banco = new Bancos();
    
    switch ($functionToCall) {
        case "getBancos":
            echo json_encode($banco->getBancos());
            break;

        case "registrarBanco":
            $banco->idbanco = $json_data['idbanco'] ?? 0;
            $banco->nombre = $json_data['nombre'];
            echo json_encode($banco->Grabar());
            break;

        case "eliminarBanco":
            echo json_encode($banco->Eliminar($json_data['id']));
            break;

        case "actualizar_pais":
            echo json_encode($banco->Actualizar($json_data['id'], $json_data['nombre']));
            break;
    }
}
