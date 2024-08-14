<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$idusuario = $_SESSION['idusuario'];
$esAdmin = true;

$section_name = "Ver Requisiciones";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Requisiciones</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/styles/menu-style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/footer.css">
    <link href="../assets/styles/ver-requisiciones.css" rel="stylesheet"> <!-- Agregamos estilos de requisición -->
</head>

<body ng-app="appRequisicion" ng-controller="verRequisicionesCtrl">

    <?php include '../menu.php'; ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12" style="padding-top: 4rem;">
                <button class="btn btn-primary mb-3" ng-click="mostrarTodo = !mostrarTodo; obtenerRequisiciones(mostrarTodo, idUsuario)">
                    {{ mostrarTodo ? 'Ver Mis Requisiciones' : 'Ver Todas las Requisiciones' }}
                </button>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th># Requisición</th>
                                <th>Estado</th>
                                <th>Solicitante</th>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Almacén</th>
                                <th>Uso</th>
                                <th>Fecha Captura</th>
                                <th>Fecha Cumplir</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="requisicion in requisiciones track by $index">
                                <td>{{ requisicion.numerorequisicion }}</td>
                                <td>
                                    <span class="status-label"
                                        ng-class="{'status-pendiente': requisicion.estado == 'PENDIENTE', 
                                                     'status-en-proceso': requisicion.estado == 'EN PROCESO', 
                                                     'status-cotizado': requisicion.estado == 'COTIZADO', 
                                                     'status-cancelado': requisicion.estado == 'CANCELADO'}">
                                        {{ requisicion.estado }}
                                    </span>
                                </td>
                                <td>{{ requisicion.usuario }}</td>
                                <td>{{ requisicion.producto_descripcion }}</td>
                                <td>{{ requisicion.unidad_descripcion }}</td>
                                <td>{{ requisicion.cantidad }}</td>
                                <td>{{ requisicion.almacen }}</td>
                                <td>{{ requisicion.uso }}</td>
                                <td>{{ requisicion.fechacaptura }}</td>
                                <td>{{ requisicion.fecha_cumplir }}</td>
                                <td>{{ requisicion.observaciones }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="footer"  style="margin-top: 1rem;">
        <div class="container">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
    <script>
        // Pasar variables PHP a JavaScript
        var idUsuario = <?php echo json_encode($idusuario); ?>;
        var esAdmin = <?php echo json_encode($esAdmin); ?>;
    </script>
    <script src="./scripts/ver_requisiciones-script.js"></script>


</body>

</html>