<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", "1");
date_default_timezone_set("America/Mexico_City");

spl_autoload_register(function($NombreClase) {
    require_once '../' . $NombreClase . '.php';
});

class Entidades {
    public $identidad = 0;
    public $nombrecomercial = "";
    public $nombrecomun = "";
    public $direccion = "";
    public $idciudad = 0;
    public $idestado = 0;
    public $idpais = 0;
    public $nombreciudad = "";
    public $nombreestado = "";
    public $nombrepais = "";
    public $rfc = "";
    public $telefono = "";
    public $correo = "";
    public $web = "";
    public $credito = 0.0;
    public $saldo = 0.0;
    public $diascredito = 0;
    public $idbanco = "";  // Asegúrate de que esté definido como string
    public $cuenta = "";
    public $clabe = "";
    public $tipo = "";

    function Grabar() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");

        $query = $cnn->prepare("call proc_EntidadGrabar(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $query->bind_param("isssiiissssddissss", 
            $this->identidad, 
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
            $this->clabe,
            $this->tipo
        );
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        }
        if ($query->num_rows != 0) {
            $query->bind_result($this->identidad);
            if ($query->fetch()) {
                if (is_null($this->identidad)) {
                    $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción. El error se desconoce.");
                } else {
                    $retorno = $this->ArrayMessage("1", "El proveedor/cliente ha sido grabado correctamente.");
                }
            }
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    // Método para generar mensajes de respuesta
    private function ArrayMessage($status, $message) {
        return array('status' => $status, 'message' => $message);
    }

    function Buscar($textoBuscar) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("call proc_EntidadBuscar(?)");
        $query->bind_param("s", $textoBuscar);
        $query->execute();
        $query->bind_result($identidad, $nombrecomercial, $rfc, $telefono, $correo, $tipo);
        while ($query->fetch()) {
            $entidad = new Entidades();
            $entidad->identidad = $identidad;
            $entidad->nombrecomercial = $nombrecomercial;
            $entidad->rfc = $rfc;
            $entidad->telefono = $telefono;
            $entidad->correo = $correo;
            $entidad->tipo = $tipo;
            array_push($retorno, $entidad);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function BuscarInfo($id_entidad) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("call proc_EntidadInfo(?)");
        $query->bind_param("s", $id_entidad);
        $query->execute();
        $query->bind_result($nombrefiscal, $nombrecomercial, $direccion, $idciudad, $nombreciudad, $idestado, $nombreestado, $idpais, $nombrepais, $rfc, $telefono, $correo, $web, $credito, $saldo, $diascredito, $idbanco, $nombrebanco, $cuenta, $clabe);
        while ($query->fetch()) {
            $entidad = array(
                "identidad" => $id_entidad,
                "nombrecomercial" => $nombrefiscal,
                "nombrecomun" => $nombrecomercial,
                "direccion" => $direccion,
                "idciudad" => $idciudad,
                "nombreciudad" => $nombreciudad,
                "idestado" => $idestado,
                "nombreestado" => $nombreestado,
                "idpais" => $idpais,
                "nombrepais" => $nombrepais,
                "rfc" => $rfc,
                "telefono" => $telefono,
                "correo" => $correo,
                "web" => $web,
                "credito" => $credito,
                "saldo" => $saldo,
                "diascredito" => $diascredito,
                "idbanco" => $idbanco,
                "nombrebanco" => $nombrebanco,
                "cuenta" => $cuenta,
                "clabe" => $clabe
            );
            array_push($retorno, $entidad);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    


    function Eliminar($idEntidad) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");
        $query = $cnn->prepare("call proc_EntidadEliminar(?)");
        $query->bind_param("i", $idEntidad);
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        }
        if ($query->num_rows != 0) {
            $query->bind_result($this->identidad);
            if ($query->fetch()) {
                if (is_null($this->identidad)) {
                    $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción. El error se desconoce.");
                } else {
                    $retorno = $this->ArrayMessage("1", "El proveedor/cliente ha sido eliminado.");
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

    function ObtenerBancos() {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL get_Bancos()");
        $query->execute();
        $query->bind_result($idbanco, $nombre);
        while ($query->fetch()) {
            $bancos = new Entidades();
            $bancos = array("idbanco" => $idbanco, "banco" => $nombre);
            array_push($retorno, $bancos);
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
    public $email = "";
    public $comentarios = "";

    function ArrayMessage($status, $message) {
        return array("status" => $status, "message" => $message, "date" => date("Y-m-d H:i:s"));
    }

    function BuscarContactos($id_entidad) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_ContactosEntidad(?)");
        $query->bind_param("i", $id_entidad);
        $query->execute();
        $query->bind_result($id_contacto, $contacto, $telefono, $celular, $email, $comentarios);
        while ($query->fetch()) {
            $contacto = array("idcontacto" => $id_contacto, "contacto" => $contacto, "telefono" => $telefono, "celular" => $celular, "email" => $email, "comentarios" => $comentarios);
            array_push($retorno, $contacto);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    function AgregarContacto($id_entidad) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_AgregarContactoEntidad(?,?,?,?,?,?)");
        $query->bind_param("isssss", 
            $id_entidad, 
            $this->contacto,
            $this->telefono,
            $this->celular,
            $this->email,
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

    function EliminarContacto($identidadcontactos) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_EliminarContactoEntidad(?)");
        $query->bind_param("i", $identidadcontactos);
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
    
    
    function EditarContacto($idcontacto, $contacto, $telefono, $celular, $email, $comentarios) {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_EditarContactoEntidad(?, ?, ?, ?, ?, ?)");
        $query->bind_param("isssss", 
            $idcontacto,
            $contacto,
            $telefono,
            $celular,
            $email,
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

class Bancos {
    public $idbanco = "";
    public $banco = "";

    
}

if (isset($_GET["functionToCall"]) && !empty($_GET["functionToCall"])) {
    $functionToCall = $_GET["functionToCall"];
    $json_data = json_decode(file_get_contents('php://input'));
    switch ($functionToCall) {
        case "buscar_entidad":
            $entidad = new Entidades();
            echo json_encode($entidad->Buscar(utf8_decode($json_data->textoBuscar)));
            break;

        case "info_entidad":
            $entidad = new Entidades();
            echo json_encode($entidad->BuscarInfo($json_data->id_entidad));
            break;

        case "grabar_entidad":
            $entidad = new Entidades();
            $entidad->identidad  = $json_data->identidad;
            $entidad->nombrecomercial  = $json_data->nombrecomercial;
            $entidad->nombrecomun  = $json_data->nombrecomun;
            $entidad->direccion  = $json_data->direccion;
            $entidad->idciudad  = $json_data->idciudad;
            $entidad->idestado  = $json_data->idestado;
            $entidad->idpais  = $json_data->idpais;
            $entidad->rfc  = $json_data->rfc;
            $entidad->telefono  = $json_data->telefono;
            $entidad->correo  = $json_data->correo;
            $entidad->web  = $json_data->web;
            $entidad->credito  = $json_data->credito;
            $entidad->saldo  = $json_data->saldo;
            $entidad->diascredito  = $json_data->diascredito;
            $entidad->idbanco  = $json_data->idbanco;
            $entidad->cuenta  = $json_data->cuenta;
            $entidad->clabe  = $json_data->clabe;
            $entidad->tipo = $json_data->tipo;

            echo json_encode($entidad->Grabar());
            break;

        case "eliminar_entidad":
            $entidad = new Entidades();
            echo json_encode($ntidad->Eliminar($json_data->identidad));
            break;
        
        case "contactos_entidad":
            $contacto = new Contactos();
            echo json_encode($contacto->BuscarContactos($json_data->id_entidad));
            break;

        case "agregar_contacto":
            $contacto = new Contactos();
            $contacto->contacto  = $json_data->contacto;
            $contacto->telefono  = $json_data->telefono;
            $contacto->celular  = $json_data->celular;
            $contacto->email = $json_data->email;
            $contacto->comentarios  = $json_data->comentarios;

            echo json_encode($contacto->AgregarContacto($json_data->id_entidad));
            break;

        case "editar_contacto":
            $contacto = new Contactos();
    

            echo json_encode($contacto->EditarContacto(
                $json_data->identidadcontactos,
                $json_data->contacto,
                $json_data->telefono,
                $json_data->celular,
                $json_data->email,
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
            $entidad = new Entidades();
            echo json_encode($entidad->ObtenerEstados($json_data->idpais));
            break;

        case "obtener_ciudades":
            $entidad = new Entidades();
            echo json_encode($entidad->ObtenerCiudades($json_data->idestado));
            break;

        case "obtener_paises":
            $entidad = new Entidades();
            echo json_encode($entidad->ObtenerPaises());
            break;

        case "obtener_bancos":
            $entidad = new Entidades();
            echo json_encode($entidad->ObtenerBancos());
            break;

    }
}