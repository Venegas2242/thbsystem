?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", 1);
?>
<!DOCTYPE html>
<!--
 * Description of Productos
 *
 * @author tyrodeveloper
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Proveedores</title>
        <!--Referencias CSS-->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body id="ng-producto-lista" ng-app="appCatalogos" ng-controller="cProductos">
        <!--PONER AQU�? EL CÓDIGO HTML-->
        <div class="container-fluid">
            <h1>Proveedores</h1>
            <hr />
            <a href="#" class="btn btn-primary" ng-click="AbrirNuevo();"><i class="glyphicon glyphicon-plus"></i> Agregar nuevo proveedor</a>
            <br /><br />
            <div class ="row">
                <div class="col-sm-6">
                    <div class="form-group input-group">
                        <input type="text" class="form-control" ng-keyup="$event.keyCode == 13 ? BuscarProducto() : null" id="txtTextoBuscar" placeholder="RFC, Nombre del proveedor" />
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    </div>
                </div>
            </div>

            <div class ="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th colspan="6" class="text-center">Listado de Proveedores</th>
                            </tr>
                            <tr>
                                <th class="text-center"><i class="glyphicon glyphicon-pencil"></i></th>
                                <th class="text-center"><i class="glyphicon glyphicon-trash"></i></th>
                                <th>RFC</th>
                                <th>Nombre Comercial</th>
                                <th class="text-right">Telefono</th>
                                <th class="text-right">Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="producto in listaProductos">
                                <td class="text-center"><a href="#" ng-click="AbrirEditar(this.producto);" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></a></td>
                                <td class="text-center"><a href="#" ng-click="AbrirEliminar(this.producto);" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a></td>
                                <td>{{producto.rfc}}</td>
                                <td>{{producto.nombrecomercial}}</td>
                                <td class="text-right">{{producto.telefono}}</td>
                                <td class="text-right">{{producto.correo}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row text-center">
                <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
            </div>


            <!-- Modal Producto -->
            <div id="modalProducto" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title">Proveedor</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>RFC:</label>
                                    <div class="form-group input-group">
                                        <input type="text" id="txtRFC" ng-model="producto.rfc" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                    <label>Nombre Comercial:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtNombreFiscal" ng-model="producto.nombrecomercial" class="form-control" />
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <label>Nombre referencia:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtNombreComun" ng-model="producto.nombrecomun" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    
                                    <label>Direccion:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtDireccion" ng-model="producto.direccion" class="form-control" />
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Ciudad:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtCiudad" ng-model="producto.idciudad" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Estado:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtEstado" ng-model="producto.idestado" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Pais:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtPais" ng-model="producto.idpais" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Telefono:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtTelefono" ng-model="producto.telefono" class="form-control" />
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <label>Correo:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtCorreo" ng-model="producto.correo" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>PaginaWeb:</label>
                                    <div class="form-group">
                                        <input type="text" id="txtWeb" ng-model="producto.web" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Monto crédito:</label>
                                    <div class="form-group input-group">
                                        <input type="text" id="txtCredito" ng-model="producto.credito" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Dias crédito:</label>
                                    <div class="form-group input-group">
                                        <input type="text" id="txtDiasCredito" ng-model="producto.diascredito" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Saldo:</label>
                                    <div class="form-group input-group">
                                        <input type="text" id="txtSaldo" ng-model="producto.saldo" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Banco:</label>
                                    <div class="form-group input-group">
                                        <input type="text" id="txtBanco" ng-model="producto.idbanco" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Cuenta:</label>
                                    <div class="form-group input-group">
                                        <input type="text" id="txtCuenta" ng-model="producto.cuenta" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>CLABE:</label>
                                    <div class="form-group input-group">
                                        <input type="text" id="txtClabe" ng-model="producto.clabe" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="modal-footer">
                            <button type="button" ng-click="Grabar()" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-disk"></i> Grabar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Producto -->

            <!-- Modal Eliminar-->
            <div id="modalProductoEliminar" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal">�</button>
                            <h4 class="modal-title" style="color:red;">¿Desea eliminar el proveedor?</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>RFC:</label>
                                    <div class="form-group input-group">

                                        <input type="text" ng-model="producto.rfc" readonly="true" class="form-control" />
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Nombre comercial:</label>
                                        <input type="text" ng-model="producto.nombrecomercial" readonly="true" class="form-control" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" ng-click="Eliminar()" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i> Eliminar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Eliminar-->


        </div>
        <!--Referencias Javascript-->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js" type="text/javascript"></script>

        <script type="text/javascript">
                                        //Código Javascript
                                        var myApp = angular.module('appCatalogos', []);

                                        myApp.controller('cProductos', function ($scope, $http) {
                                            var myData = {textoBuscar: ''};
                                            $scope.producto = {id_producto: 0, nombrecomercial: "", rfc: "", telefono: 0, correo: 0};
                                            $http({
                                                method: "POST",
                                                url: 'cod-formulario-abc.php?functionToCall=buscar_producto',
                                                data: myData}).then(function (response) {
                                                $scope.listaProductos = response.data;
                                            });

                                            $scope.BuscarProducto = function () {
                                                var myData = {textoBuscar: String($("#txtTextoBuscar").val())};
                                                $http({
                                                    method: "POST",
                                                    url: 'cod-formulario-abc.php?functionToCall=buscar_producto',
                                                    data: myData}).then(function (response) {
                                                    $scope.listaProductos = response.data;
                                                });
                                            };

                                            $scope.AbrirEditar = function (item) {
                                                $scope.producto = item;
                                                $("#modalProducto").modal();
                                            };
                                            $scope.AbrirNuevo = function () {
                                                $scope.producto = {id_producto: 0, codigo_barras: "", nombre_producto: "", stock: 0, precio_venta: 0};
                                                $("#modalProducto").modal();
                                            };
                                            $scope.Grabar = function () {
                                                $http({
                                                    method: "POST",
                                                    url: 'cod-formulario-abc.php?functionToCall=grabar_producto',
                                                    data: $scope.producto}).then(function (response) {
                                                    if (response.data.status === "1") {
                                                        alert(response.data.message);
                                                        $scope.BuscarProducto();
                                                        $("#modalProducto").modal("hide");
                                                    } else {
                                                        alert(response.data.message);
                                                    }
                                                });
                                            };

                                            $scope.AbrirEliminar = function (item) {
                                                $scope.producto = item;
                                                $("#modalProductoEliminar").modal();
                                            };

                                            $scope.Eliminar = function () {
                                                $http({
                                                    method: "POST",
                                                    url: 'cod-formulario-abc.php?functionToCall=eliminar_producto',
                                                    data: $scope.producto}).then(function (response) {
                                                    if (response.data.status === "1") {
                                                        alert(response.data.message);
                                                        $scope.BuscarProducto();
                                                        $("#modalProductoEliminar").modal("hide");
                                                    } else {
                                                        alert(response.data.message);
                                                    }
                                                });
                                            };

                                        });
        </script>
    </body>
</html>