<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$section_name = "Proveedores/Clientes";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $section_name; ?></title>
    <!-- Referencias CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../assets/styles/entidades-style.css">
    <link rel="stylesheet" href="../assets/styles/modales.css">
    <link rel="stylesheet" href="../assets/styles/footer.css">
</head>

<body id="ng-entidad-lista" ng-app="appCatalogos" ng-controller="cCatalogos">

    <?php include '../menu.php'; ?>

    <div class="container fade-in content-wrapper">
        <div class="main-content">

            <a href="#" class="btn btn-primary-custom btn-agregar mb-4" ng-click="AbrirNuevo();"><i class="fa fa-plus"></i> Agregar proveedor/cliente</a>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="input-group">
                        <input type="text" class="search-bar form-control" ng-keyup="$event.keyCode == 13 ? BuscarEntidad() : null" id="txtTextoBuscar" placeholder="RFC, Nombre del proveedor o cliente" />
                        <div class="input-group-append">
                            <span class="input-group-text" ng-click="BuscarEntidad()"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 radio-container">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoEntidad" id="radioTodos" ng-model="tipoEntidad" value="" ng-change="FiltrarEntidad()" checked="checked">
                        <label class="form-check-label" for="radioTodos">Todos</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoEntidad" id="radioClientes" ng-model="tipoEntidad" value="Cliente" ng-change="FiltrarEntidad()">
                        <label class="form-check-label" for="radioClientes">Clientes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoEntidad" id="radioProveedores" ng-model="tipoEntidad" value="Proveedor" ng-change="FiltrarEntidad()">
                        <label class="form-check-label" for="radioProveedores">Proveedores</label>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre Comercial</th>
                            <th>Tipo</th>
                            <th>RFC</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="entidad in listaEntidades | filter:{tipo:tipoEntidad}">
                            <td>{{entidad.nombrecomercial}}</td>
                            <td>{{entidad.tipo}}</td>
                            <td>{{entidad.rfc}}</td>
                            <td>{{entidad.telefono}}</td>
                            <td>{{entidad.correo}}</td>
                            <td>
                                <a href="#" ng-click="MostrarContactos(this.entidad);" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-address-book"></i> Contactos
                                </a>
                                <a href="#" ng-click="AbrirEditar(this.entidad);" class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil-alt"></i> Editar
                                </a>
                                <a href="#" ng-click="AbrirEliminar(this.entidad);" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash-alt"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php include './modal/eliminar-entidad.php'; ?>
        <?php include './modal/agregar-entidad.php'; ?>
        <?php include './modal/editar-entidad.php'; ?>
        <?php include './modal/contactos-entidad.php'; ?>
    </div>

    <div class="footer">
        <div class="container">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>
    </div>

    <!-- Referencias Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js" type="text/javascript"></script>

    <script src="./scripts/catalogos-script.js"></script>
</body>

</html>