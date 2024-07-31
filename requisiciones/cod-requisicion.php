<?php

require_once '../Connection.php';

class Productos
{
    private function ArrayMessage($status, $message)
    {
        return array('status' => $status, 'message' => $message);
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

    public function BuscarProductos($textoBuscar)
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
            if (stripos($descripcion, $textoBuscar) !== false || stripos($codigo, $textoBuscar) !== false) {
                $producto = array(
                    "idproducto" => $idproducto,
                    "descripcion" => $descripcion,
                    "codigo" => $codigo
                );
                array_push($retorno, $producto);
            }
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
        case "obtener_unidades":
            $idUnidad = isset($_GET["idUnidad"]) ? intval($_GET["idUnidad"]) : null;
            echo json_encode($productos->ObtenerUnidades($idUnidad));
            break;
        case "buscar_productos":
            $textoBuscar = isset($_GET["textoBuscar"]) ? $_GET["textoBuscar"] : '';
            echo json_encode($productos->BuscarProductos($textoBuscar));
            break;
    }
}
