<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$section_name = "Productos";
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
    <link rel="stylesheet" href="../assets/styles/productos-style.css">
    <link rel="stylesheet" href="../assets/styles/modales.css">
    <link rel="stylesheet" href="../assets/styles/footer.css">
</head>

<body id="ng-producto-lista" ng-app="appProductos" ng-controller="cProductos">

    <?php include '../menu.php'; ?>

    <div class="container fade-in content-wrapper">
        <div class="main-content">

            <a href="#" class="btn btn-primary-custom mb-4" ng-click="AbrirNuevo();" style="font-size: 1.5rem; padding: 1rem 2rem;"><i class="fa fa-plus"></i> Agregar producto</a>

            <!-- Botones para agregar Unidades, Grupos y Tipos -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <button class="btn btn-secondary btn-block" ng-click="AbrirAgregarUnidad()"><i class="fa fa-plus"></i> Agregar Unidad</button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary btn-block" ng-click="AbrirAgregarGrupo()"><i class="fa fa-plus"></i> Agregar Grupo</button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary btn-block" ng-click="AbrirAgregarTipo()"><i class="fa fa-plus"></i> Agregar Tipo</button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="input-group">
                        <input type="text" class="search-bar form-control" ng-keyup="$event.keyCode == 13 ? BuscarProducto() : null" id="txtTextoBuscar" placeholder="Descripción del producto o código" />
                        <div class="input-group-append">
                            <span class="input-group-text" ng-click="BuscarProducto()"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4" ng-repeat="producto in listaProductos track by producto.idproducto">
                    <div class="card">
                        <div class="card-content">
                            <span class="delete-icon" ng-click="AbrirEliminar(producto);"><i class="fa fa-trash-alt"></i></span>
                            <div class="card-details">
                                <h5 class="mb-1">{{producto.descripcion}}</h5>
                                <p class="mb-1">
                                    <strong>Código:</strong> {{producto.codigo}}<br>
                                    <strong>Ubicación:</strong> {{producto.ubicacion}}<br>
                                    <strong>Costo:</strong> {{producto.costo}}
                                </p>
                            </div>
                            <div class="card-actions">
                                <a href="#" ng-click="AbrirEditar(producto);" class="btn btn-primary-custom"><i class="fa fa-pencil-alt"></i> Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php include './modal/agregar-producto.php'; ?>
        <?php include './modal/editar-producto.php'; ?>
        <?php include './modal/eliminar-producto.php'; ?>
    </div>

    <div class="footer">
        <div class="container">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>
    </div>

    <!-- Modal para agregar Unidad -->
    <div id="modalAgregarUnidad" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Unidad</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nuevaUnidadDescripcion">Descripción:</label>
                        <input type="text" id="nuevaUnidadDescripcion" ng-model="nuevaUnidad.descripcion" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" ng-click="AgregarUnidad()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar Grupo -->
    <div id="modalAgregarGrupo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Grupo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nuevoGrupoDescripcion">Descripción:</label>
                        <input type="text" id="nuevoGrupoDescripcion" ng-model="nuevoGrupo.descripcion" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" ng-click="AgregarGrupo()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar Tipo -->
    <div id="modalAgregarTipo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Tipo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nuevoTipoDescripcion">Descripción:</label>
                        <input type="text" id="nuevoTipoDescripcion" ng-model="nuevoTipo.descripcion" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" ng-click="AgregarTipo()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Notificación -->
    <div id="modalNotificacion" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Notificación</h4>
                </div>
                <div class="modal-body">
                    <p id="mensajeNotificacion"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-custom" data-dismiss="modal"><i class="fa fa-check"></i> Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Referencias Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js" type="text/javascript"></script>

    <script src="./scripts/productos-script.js"></script>
</body>

</html>