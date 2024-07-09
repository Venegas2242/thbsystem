<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
    <!-- Referencias CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="./styles/proveedores-style.css">
</head>
<body id="ng-proveedor-lista" ng-app="appCatalogos" ng-controller="cProveedores">

    <?php include 'menu.php'; ?>
    
    <div class="container fade-in content-wrapper">
        <h1 class="my-4">Proveedores</h1>
        <a href="#" class="btn btn-primary-custom mb-4" ng-click="AbrirNuevo();"><i class="fa fa-plus"></i> Agregar nuevo proveedor</a>

        <div class="row mb-4">
            <div class="col-12">
                <div class="input-group">
                    <input type="text" class="search-bar form-control" ng-keyup="$event.keyCode == 13 ? BuscarProveedor() : null" id="txtTextoBuscar" placeholder="RFC, Nombre del proveedor" />
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12" ng-repeat="proveedor in listaProveedores">
                <div class="card">
                    <span class="contacts-icon" ng-click="MostrarContactos(this.proveedor);"><i class="fa-solid fa-address-book"></i></span>
                    <span class="delete-icon" ng-click="AbrirEliminar(this.proveedor);"><i class="fa fa-trash-alt"></i></span>
                    <div>
                        <h5 class="mb-1">{{proveedor.nombrecomercial}}</h5>
                        <p class="mb-1">
                            <strong>RFC:</strong> {{proveedor.rfc}}<br>
                            <strong>Teléfono:</strong> {{proveedor.telefono}}<br>
                            <strong>Correo:</strong> {{proveedor.correo}}
                        </p>
                    </div>
                    <div class="mt-3">
                        <a href="#" ng-click="AbrirEditar(this.proveedor);" class="btn btn-primary-custom"><i class="fa fa-pencil-alt"></i> Editar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>

        <?php include 'modal/eliminar-proveedor.php'; ?>
        <?php include 'modal/agregar-proveedor.php'; ?>
        <?php include 'modal/editar-proveedor.php'; ?>
        <?php include 'modal/contactos-proveedor.php'; ?>
    </div>

    <!-- Referencias Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js" type="text/javascript"></script>

    <script src="scripts/proveedores-script.js"></script>
</body>
</html>
