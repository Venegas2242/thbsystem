<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", "1");
date_default_timezone_set("America/Mexico_City");

spl_autoload_register(function($NombreClase) {
    require_once '../' . $NombreClase . '.php';
});

class Usuarios {
    public $idusuario = 0;
    public $nombre = "";
    public $contrasena = "";

    function Grabar() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");

        $query = $cnn->prepare("CALL proc_UsuarioGrabar(?, ?, ?)");
        $query->bind_param("iss", 
            $this->idusuario, 
            $this->nombre, 
            $this->contrasena
        );
        $query->execute();
        if ($query->errno) {
            $retorno = $this->ArrayMessage("0", $query->error);
        } else {
            $retorno = $this->ArrayMessage("1", "El usuario ha sido grabado correctamente.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    private function ArrayMessage($status, $message) {
        return array('status' => $status, 'message' => $message);
    }

    function getUsuarios() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_getUsuarios()");
        $query->execute();
        $query->bind_result($idusuario, $nombre);
        while ($query->fetch()) {
            $usuario = array(
                "id" => $idusuario,
                "nombre" => $nombre
            );
            array_push($retorno, $usuario);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function Eliminar($idUsuario) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");
        $query = $cnn->prepare("CALL proc_UsuarioEliminar(?)");
        $query->bind_param("i", $idUsuario);
        $query->execute();
        if ($query->errno) {
            $retorno = $this->ArrayMessage("0", $query->error);
        } else {
            $retorno = $this->ArrayMessage("1", "El usuario ha sido eliminado.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function ActualizarContrasena($idUsuario, $contrasena) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");

        $query = $cnn->prepare("CALL proc_ActualizarContrasena(?, SHA2(?, 256))");
        $query->bind_param("is", $idUsuario, $contrasena);
        $query->execute();
        if ($query->errno) {
            $retorno = $this->ArrayMessage("0", $query->error);
        } else {
            $retorno = $this->ArrayMessage("1", "La contraseña ha sido actualizada.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }
}

if (isset($_GET["functionToCall"]) && !empty($_GET["functionToCall"])) {
    $functionToCall = $_GET["functionToCall"];
    $json_data = json_decode(file_get_contents('php://input'), true);
    $usuario = new Usuarios();
    
    switch ($functionToCall) {
        case "getUsuarios":
            echo json_encode($usuario->getUsuarios());
            break;

        case "registrarUsuario":
            $usuario->idusuario = $json_data['idusuario'] ?? 0;
            $usuario->nombre = $json_data['usuario'];
            $usuario->contrasena = $json_data['contrasena'];
            echo json_encode($usuario->Grabar());
            break;

        case "eliminarUsuario":
            echo json_encode($usuario->Eliminar($json_data['id']));
            break;

        case "actualizarContrasena":
            echo json_encode($usuario->ActualizarContrasena($json_data['id'], $json_data['contrasena']));
            break;
    }
}
