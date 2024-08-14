<?php

require_once '../Connection.php';

abstract class tipodocumento
{
    const REQUISICION = 1;
    const ORDENDECOMPRA = 2;
    const RECEPCIONMERCANCIA = 3;
    const ORDENDESERVICIO = 4;
    const ORDENDETRABAJO = 5;
    const COTIZACION = 6;
    const ENTRADAS = 7;
    const SALIDAS = 8;
}

abstract class EstadoRequisicion
{
    const PENDIENTE = 1;
    const ENPROCESO = 2;
    const COTIZADO = 3;
    const CANCELADO = 0;

    public static function obtenerEstado($estado)
    {
        switch ($estado) {
            case self::PENDIENTE:
                return "PENDIENTE";
            case self::ENPROCESO:
                return "EN PROCESO";
            case self::COTIZADO:
                return "COTIZADO";
            case self::CANCELADO:
                return "CANCELADO";
            default:
                return "DESCONOCIDO";
        }
    }
}

class Requisicion
{
    private function ArrayMessage($status, $message)
    {
        return array('status' => $status, 'message' => $message);
    }

    public function InsertarRequisicion($idusuario, $numerorequisicion, $fechacaptura, $estado, $observaciones, $detalles)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();

        // Iniciar una transacción
        $cnn->begin_transaction();

        try {
            // Llamar al SP para insertar la requisición y generar el idrequisicion
            $query = $cnn->prepare("CALL sp_insertar_requisicion(?, ?, ?, ?, ?, @idrequisicion)");
            $query->bind_param("issis", $idusuario, $numerorequisicion, $fechacaptura, $estado, $observaciones);
            $query->execute();

            // Obtener el idrequisicion generado
            $result = $cnn->query("SELECT @idrequisicion AS idrequisicion");
            $row = $result->fetch_assoc();
            $idrequisicion = $row['idrequisicion'];

            // Insertar detalles de la requisición
            foreach ($detalles as $detalle) {
                $queryDetalle = $cnn->prepare("CALL sp_insertar_requisicion_detalle(?, ?, ?, ?, ?, ?, ?)");
                $queryDetalle->bind_param(
                    "sississ",
                    $idrequisicion,          // UUID generado
                    $detalle->idproducto,    // Acceder como objeto
                    $detalle->cantidad,      // Acceder como objeto
                    $detalle->idunidad,      // Acceder como objeto
                    $detalle->almacen,       // Acceder como objeto
                    $detalle->fecha_cumplir, // Acceder como objeto
                    $detalle->uso            // Acceder como objeto
                );
                $queryDetalle->execute();
            }

            // Confirmar la transacción
            $cnn->commit();

            return $this->ArrayMessage(true, "Requisición insertada con éxito.");
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $cnn->rollback();
            return $this->ArrayMessage(false, "Error al insertar la requisición: " . $e->getMessage());
        } finally {
            $query->close();
            $cnn->close();
        }
    }

    public function ObtenerRequisiciones($mostrarTodo, $idusuario)
    {
        $mysql = new Connection();
        $cnn = $mysql->getConnection();

        $stmt = $cnn->prepare("CALL mostrarRequisiciones(?, ?)");
        $stmt->bind_param("ii", $mostrarTodo, $idusuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $requisiciones = [];

        while ($row = $result->fetch_assoc()) {
            // Convertir el estado a su representación textual
            $row['estado'] = EstadoRequisicion::obtenerEstado($row['estado']);
            $requisiciones[] = $row;
        }

        $stmt->close();
        $cnn->close();

        return $requisiciones;
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

    $requisicion = new Requisicion();

    switch ($functionToCall) {
        case "obtener_unidades":
            $idUnidad = isset($_GET["idUnidad"]) ? intval($_GET["idUnidad"]) : null;
            echo json_encode($requisicion->ObtenerUnidades($idUnidad));
            break;
        case "buscar_productos":
            $textoBuscar = isset($_GET["textoBuscar"]) ? $_GET["textoBuscar"] : '';
            echo json_encode($requisicion->BuscarProductos($textoBuscar));
            break;
        case "alta_requisicion":
            echo json_encode($requisicion->InsertarRequisicion(
                $json_data->idusuario,
                $json_data->numerorequisicion,
                $json_data->fechacaptura,
                $json_data->estado,
                $json_data->observaciones,
                $json_data->detalles
            ));
            break;
        case "obtener_requisiciones":
            $mostrarTodo = isset($_GET["mostrarTodo"]) ? intval($_GET["mostrarTodo"]) : 0;
            $idusuario = isset($_GET["idusuario"]) ? intval($_GET["idusuario"]) : 0;
            echo json_encode($requisicion->ObtenerRequisiciones($mostrarTodo, $idusuario));
            break;
        case "alta2_requisicion":
            echo tipodocumento::REQUISICION;
            break;
    }
}
?>
