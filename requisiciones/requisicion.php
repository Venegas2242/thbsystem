<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario']; // Obtener el nombre del usuario de la sesión
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
    <style>
        body {
            background-color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .form-title {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            color: white;
        }

        .main-content {
            padding: 20px;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #fff;
            opacity: 1;
        }

        .autocomplete-suggestions {
            border: 1px solid #e4e4e4;
            max-height: 150px;
            overflow-y: auto;
        }

        .autocomplete-suggestion {
            padding: 10px;
            cursor: pointer;
        }

        .autocomplete-suggestion:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body id="ng-requisicion-lista" ng-app="appRequisicion" ng-controller="cRequisicion">
    <?php include '../menu.php'; ?>

    <div class="main-content">
        <div class="form-title">Formulario de Requisición</div>
        <form name="requisicionForm" ng-submit="AgregarDatos(requisicionForm)">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="almacen">Selecciona Almacen:</label>
                    <select class="form-control" id="almacen" name="almacen" ng-model="requisicion.almacen" required>
                        <option value="" selected disabled>Selecciona...</option>
                        <option value="1">Opción 1</option>
                        <option value="2">Opción 2</option>
                        <option value="3">Opción 3</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="fecha">Selecciona Fecha a Cumplir Necesidad:</label>
                    <input type="text" class="form-control datepicker" id="fecha" name="fecha" placeholder="Selecciona una fecha" ng-model="requisicion.fecha" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="articulo">Selecciona Artículo:</label>
                    <input type="text" class="form-control" id="articulo" name="articulo" placeholder="Tecla el artículo y selecciona" ng-model="textoBuscar" ng-change="BuscarProducto()" required>
                    <div class="autocomplete-suggestions" ng-show="sugerencias.length > 0">
                        <div class="autocomplete-suggestion" ng-repeat="sugerencia in sugerencias" ng-click="SeleccionarProducto(sugerencia)">
                            {{sugerencia.descripcion}}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="unidad">Unidad de Medida:</label>
                    <div class="input-group">
                        <select id="unidad" class="form-control" ng-model="requisicion.unidad" required>
                            <option value="" selected disabled>Seleccione una unidad</option>
                            <option ng-repeat="unidad in listaUnidades" value="{{unidad.idunidad}}">{{unidad.descripcion}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" ng-model="requisicion.cantidad" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="uso">Selecciona Uso:</label>
                    <select class="form-control" id="uso" name="uso" ng-model="requisicion.uso" required>
                        <option value="" selected disabled>Selecciona...</option>
                        <option value="1">Uso 1</option>
                        <option value="2">Uso 2</option>
                        <option value="3">Uso 3</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Agregar Datos</button>
        </form>

        <div class="mt-4">
            <h5>Artículos Seleccionados</h5>
            <div style="overflow-x: auto;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Almacen</th>
                            <th>Artículo</th>
                            <th>UM</th>
                            <th>Cantidad</th>
                            <th>Uso</th>
                            <th>Fecha Cumplir</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="articulo in articulosSeleccionados">
                            <td>{{articulo.almacen}}</td>
                            <td>{{articulo.articulo}}</td>
                            <td>{{articulo.unidad}}</td>
                            <td>{{articulo.cantidad}}</td>
                            <td>{{articulo.uso}}</td>
                            <td>{{articulo.fecha}}</td>
                            <td><button class="btn btn-danger btn-sm" ng-click="QuitarArticulo($index)">X</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="solicitante">Solicitante:</label>
                <input type="text" class="form-control" id="solicitante" name="solicitante" value="<?php echo htmlspecialchars($usuario); ?>" readonly>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Enviar Solicitud</button>
    </div>

    <div class="footer">
        <div class="container">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="./scripts/requisicion-script.js"></script>
</body>

</html>