<?php

require_once '../Connection.php';

class Productos
{
    private function ArrayMessage($status, $message)
    {
        return array('status' => $status, 'message' => $message);
    }

    public function ObtenerProductos()
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL obtener_productos()");
        $query->execute();
        $query->bind_result(
            $idproducto,
            $codigo,
            $descripcion,
            $ubicacion,
            $costo,
            $codigobarras,
            $idunidad,
            $unidad,
            $idgrupoproducto,
            $grupo,
            $idproveedor,
            $proveedor,
            $idtipoproducto,
            $tipoproducto
        );
        while ($query->fetch()) {
            $producto = array(
                "idproducto" => $idproducto,
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "ubicacion" => $ubicacion,
                "costo" => $costo,
                "codigobarras" => $codigobarras,
                "idunidad" => $idunidad,
                "unidad" => $unidad,
                "idgrupoproducto" => $idgrupoproducto,
                "grupo" => $grupo,
                "idproveedor" => $idproveedor,
                "proveedor" => $proveedor,
                "idtipoproducto" => $idtipoproducto,
                "tipoproducto" => $tipoproducto
            );
            array_push($retorno, $producto);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function ObtenerUnidades($idUnidad = null)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();

        if ($idUnidad === null) {
            $query = $cnn->prepare("CALL obtener_unidades(NULL)");
        } else {
            $query = $cnn->prepare("CALL obtener_unidades(?)");
            $query->bind_param("i", $idUnidad);
        }

        $query->execute();
        $query->bind_result($idunidad, $descripcion);
        while ($query->fetch()) {
            $unidad = array("idunidad" => $idunidad, "descripcion" => $descripcion);
            array_push($retorno, $unidad);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function ObtenerGrupos($idGrupo = null)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();

        if ($idGrupo === null) {
            $query = $cnn->prepare("CALL obtener_grupos(NULL)");
        } else {
            $query = $cnn->prepare("CALL obtener_grupos(?)");
            $query->bind_param("i", $idGrupo);
        }

        $query->execute();
        $query->bind_result($idgrupoproducto, $descripcion);
        while ($query->fetch()) {
            $grupo = array("idgrupoproducto" => $idgrupoproducto, "descripcion" => $descripcion);
            array_push($retorno, $grupo);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function ObtenerTipos($idTipo = null)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();

        if ($idTipo === null) {
            $query = $cnn->prepare("CALL obtener_tipos(NULL)");
        } else {
            $query = $cnn->prepare("CALL obtener_tipos(?)");
            $query->bind_param("i", $idTipo);
        }

        $query->execute();
        $query->bind_result($idtipoproducto, $descripcion);
        while ($query->fetch()) {
            $tipo = array("idtipoproducto" => $idtipoproducto, "descripcion" => $descripcion);
            array_push($retorno, $tipo);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function ObtenerProveedores($idProveedor = null)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();

        if ($idProveedor === null) {
            $query = $cnn->prepare("CALL obtener_proveedores(NULL)");
        } else {
            $query = $cnn->prepare("CALL obtener_proveedores(?)");
            $query->bind_param("i", $idProveedor);
        }

        $query->execute();
        $query->bind_result($identidad, $nombre);
        while ($query->fetch()) {
            $proveedor = array("identidad" => $identidad, "nombre" => $nombre);
            array_push($retorno, $proveedor);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function GrabarProducto($producto)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");

        $query = $cnn->prepare("CALL agregar_producto(?,?,?,?,?,?,?,?,?)");
        $query->bind_param(
            "sssdsiiii",
            $producto->codigo,
            $producto->descripcion,
            $producto->ubicacion,
            $producto->costo,
            $producto->codigobarras,
            $producto->idunidad,
            $producto->idgrupoproducto,
            $producto->idproveedor,
            $producto->idtipoproducto
        );
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        } else {
            $retorno = $this->ArrayMessage("1", "El producto ha sido agregado correctamente.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function EliminarProducto($idproducto)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();

        $query = $cnn->prepare("CALL eliminar_producto(?)");
        $query->bind_param("i", $idproducto);
        $query->execute();
        if ($query->error) {
            $retorno = array("status" => "0", "message" => $query->error);
        } else {
            $retorno = array("status" => "1", "message" => "Producto desactivado exitosamente.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function ActualizarProducto($producto)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = $this->ArrayMessage("0", "No se ha realizado ninguna acción.");

        $query = $cnn->prepare("CALL actualizar_producto(?,?,?,?,?,?,?,?,?,?)");
        $query->bind_param(
            "isssdiiiii",
            $producto->idproducto,
            $producto->codigo,
            $producto->descripcion,
            $producto->ubicacion,
            $producto->costo,
            $producto->codigobarras,
            $producto->idunidad,
            $producto->idgrupoproducto,
            $producto->idproveedor,
            $producto->idtipoproducto
        );
        $query->execute();
        $query->store_result();
        if (mysqli_stmt_error($query) != "") {
            $retorno = $this->ArrayMessage("0", mysqli_stmt_error($query));
        } else {
            $retorno = $this->ArrayMessage("1", "El producto ha sido actualizado correctamente.");
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }

    public function Buscar($textoBuscar)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();
        $retorno = array();
        $query = $cnn->prepare("CALL proc_ProductoBuscar(?)");
        $query->bind_param("s", $textoBuscar);
        $query->execute();
        $query->bind_result($idproducto, $descripcion, $codigo, $ubicacion, $costo);
        while ($query->fetch()) {
            $producto = array(
                "idproducto" => $idproducto,
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "ubicacion" => $ubicacion,
                "costo" => $costo
            );
            array_push($retorno, $producto);
        }
        $query->close();
        $cnn->close();
        return $retorno;
    }
}


if (isset($_GET["functionToCall"]) && !empty($_GET["functionToCall"])) {
    $functionToCall = $_GET["functionToCall"];
    $json_data = json_decode(file_get_contents('php://input'));
    $productos = new Productos();

    switch ($functionToCall) {
        case "obtener_productos":
            echo json_encode($productos->ObtenerProductos());
            break;
        case "obtener_unidades":
            $idUnidad = isset($_GET["idUnidad"]) ? intval($_GET["idUnidad"]) : null;
            echo json_encode($productos->ObtenerUnidades($idUnidad));
            break;
        case "obtener_grupos":
            $idGrupo = isset($_GET["idGrupo"]) ? intval($_GET["idGrupo"]) : null;
            echo json_encode($productos->ObtenerGrupos($idGrupo));
            break;
        case "obtener_tipos":
            $idTipo = isset($_GET["idTipo"]) ? intval($_GET["idTipo"]) : null;
            echo json_encode($productos->ObtenerTipos($idTipo));
            break;
        case "obtener_proveedores":
            $idProveedor = isset($_GET["idProveedor"]) ? intval($_GET["idProveedor"]) : null;
            echo json_encode($productos->ObtenerProveedores($idProveedor));
            break;
        case "grabar_producto":
            echo json_encode($productos->GrabarProducto($json_data));
            break;
        case "eliminar_producto":
            echo json_encode($productos->EliminarProducto($json_data->idproducto));
            break;
        case "actualizar_producto":
            echo json_encode($productos->ActualizarProducto($json_data));
            break;
        case "buscar_producto":
            echo json_encode($productos->Buscar($json_data->textoBuscar));
            break;
    }
}
