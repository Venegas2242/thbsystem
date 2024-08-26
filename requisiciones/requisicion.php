<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario']; // Obtener el nombre del usuario de la sesión
$idusuario = $_SESSION['idusuario']; // Obtener el id del usuario de la sesión

$section_name = "Requisición";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisiciones</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/footer.css">
    <link rel="stylesheet" href="../assets/styles/menu-style.css">
    <link rel="stylesheet" href="../assets/styles/requisicion.css"> <!-- Nuevo archivo de estilos -->
</head>

<body id="ng-requisicion-lista" ng-app="appRequisicion" ng-controller="cRequisicion">

    <?php include '../menu.php'; ?>

    <div class="container mt-4" style="padding-top: 4rem;">
        <form name="requisicionForm" ng-submit="AgregarDatos(requisicionForm)">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="articulo">Selecciona Artículo:</label>
                    <input type="text" class="form-control" id="articulo" name="articulo" placeholder="Tecla el artículo y selecciona" ng-model="textoBuscar" ng-change="BuscarProducto()" autocomplete="off" required>
                    <div class="autocomplete-suggestions" ng-show="sugerencias.length > 0">
                        <div class="autocomplete-suggestion" ng-repeat="sugerencia in sugerencias" ng-click="SeleccionarProducto(sugerencia)" value="{{sugerencia.idproducto}}">
                            {{sugerencia.codigo}} - {{sugerencia.descripcion}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="unidad">Unidad de Medida:</label>
                    <select id="unidad" class="form-control" ng-model="requisicion.unidad" required>
                        <option value="" selected disabled>Seleccione una unidad</option>
                        <option ng-repeat="unidad in listaUnidades" value="{{unidad.idunidad}}">{{unidad.descripcion}}</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" ng-model="requisicion.cantidad" step="0.01" required>
                </div>
            </div>

            <button type="submit" class="btn btn-custom btn-block mt-4">Agregar Datos</button>
        </form>

        <div class="mt-5">
            <h5>Artículos Seleccionados</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th>UM</th>
                            <th>Cantidad</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="articulo in articulosSeleccionados">
                            <td>{{articulo.producto}}</td>
                            <td>{{articulo.unidad}}</td>
                            <td>{{articulo.cantidad}}</td>
                            <td><button class="btn btn-danger btn-sm" ng-click="QuitarArticulo($index)">X</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="fecha">Selecciona Fecha a Cumplir Necesidad:</label>
                <input type="text" class="form-control datepicker" id="fecha" name="fecha" placeholder="Selecciona una fecha" ng-model="requisicion.fecha" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="comentarios">Comentarios:</label>
                <textarea id="comentarios" rows="4" class="form-control" cols="50"></textarea>
            </div>
        </div>

        <!-- <button style="margin-bottom: 10px;" type="button" class="btn btn-primary btn-block mt-4" ng-click="EnviarSolicitud(<?php echo $idusuario; ?>)">Enviar Solicitud</button> -->
    </div>

    <div class="footer">
        <div class="container">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>
    </div>

    <?php include './modal/modal_notificacion.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="./scripts/requisicion-script.js"></script>
</body>

</html>