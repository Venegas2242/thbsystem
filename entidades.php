<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: login.php");
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
    <link rel="stylesheet" href="./styles/entidades-style.css">
    <link rel="stylesheet" href="./styles/modales.css">
    <link rel="stylesheet" href="./styles/footer.css">
</head>

<body id="ng-entidad-lista" ng-app="appCatalogos" ng-controller="cCatalogos">

    <?php include 'menu.php'; ?>

    <div class="container fade-in content-wrapper">
        <div class="main-content">

            <a href="#" class="btn btn-primary-custom mb-4" ng-click="AbrirNuevo();"><i class="fa fa-plus"></i> Agregar proveedor/cliente</a>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="input-group">
                        <input type="text" class="search-bar form-control" ng-keyup="$event.keyCode == 13 ? BuscarEntidad() : null" id="txtTextoBuscar" placeholder="RFC, Nombre del proveedor o cliente" />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12" ng-repeat="entidad in listaEntidades">
                    <div class="card" ng-class="{'card-cliente': entidad.tipo === 'Cliente', 'card-proveedor': entidad.tipo === 'Proveedor'}">
                        <span class="contacts-icon" ng-click="MostrarContactos(this.entidad);"><i class="fa-solid fa-address-book"></i></span>
                        <span class="delete-icon" ng-click="AbrirEliminar(this.entidad);"><i class="fa fa-trash-alt"></i></span>
                        <div>
                            <h5 class="mb-1">{{entidad.nombrecomercial}}</h5>
                            <p class="mb-1">
                                <strong class="tipo-entidad">{{entidad.tipo}}</strong><br>
                                <strong>RFC:</strong> {{entidad.rfc}}<br>
                                <strong>Teléfono:</strong> {{entidad.telefono}}<br>
                                <strong>Correo:</strong> {{entidad.correo}}
                            </p>
                        </div>
                        <div class="mt-3">
                            <a href="#" ng-click="AbrirEditar(this.entidad);" class="btn btn-primary-custom"><i class="fa fa-pencil-alt"></i> Editar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'modal/eliminar-entidad.php'; ?>
        <?php include 'modal/agregar-entidad.php'; ?>
        <?php include 'modal/editar-entidad.php'; ?>
        <?php include 'modal/contactos-entidad.php'; ?>
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

    <script src="scripts/catalogos-script.js"></script>
</body>

</html>
