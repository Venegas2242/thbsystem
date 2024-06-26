<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
    <!-- Referencias CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="styles/proveedores-style.css">
</head>
<body id="ng-producto-lista" ng-app="appCatalogos" ng-controller="cProductos">

    <?php include 'menu.php'; ?>
    
    <div class="container fade-in content-wrapper">
        <h1 class="my-4">Proveedores</h1>
        <a href="#" class="btn btn-primary mb-4" ng-click="AbrirNuevo();"><i class="fa fa-plus"></i> Agregar nuevo proveedor</a>

        <div class="row mb-4">
            <div class="col-12">
                <div class="input-group">
                    <input type="text" class="form-control" ng-keyup="$event.keyCode == 13 ? BuscarProducto() : null" id="txtTextoBuscar" placeholder="RFC, Nombre del proveedor" />
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12" ng-repeat="producto in listaProductos">
                <div class="card">
                    <span class="delete-icon" ng-click="AbrirEliminar(this.producto);"><i class="fa fa-trash-alt"></i></span>
                    <div>
                        <h5 class="mb-1">{{producto.nombrecomercial}}</h5>
                        <p class="mb-1">
                            <strong>RFC:</strong> {{producto.rfc}}<br>
                            <strong>Teléfono:</strong> {{producto.telefono}}<br>
                            <strong>Correo:</strong> {{producto.correo}}
                        </p>
                    </div>
                    <div class="mt-3">
                        <a href="#" ng-click="AbrirEditar(this.producto);" class="btn btn-primary mb-1"><i class="fa fa-pencil-alt"></i> Editar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>

        <!-- Modal Producto -->
        <div id="modalProducto" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Proveedor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>RFC:</label>
                                <input type="text" id="txtRFC" ng-model="producto.rfc" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nombre Comercial:</label>
                                <input type="text" id="txtNombreFiscal" ng-model="producto.nombrecomercial" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nombre referencia:</label>
                                <input type="text" id="txtNombreComun" ng-model="producto.nombrecomun" class="form-control" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Direccion:</label>
                                <input type="text" id="txtDireccion" ng-model="producto.direccion" class="form-control" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>País:</label>
                                <select id="cmbPais" ng-model="ubicacion.idpais" ng-change="cambiarPais()" class="form-control">
                                    <option value="">Seleccione un país</option>
                                    <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Estado:</label>
                                <select id="cmbEstado" ng-model="ubicacion.idestado" ng-change="cambiarEstado()" class="form-control">
                                    <option value="">Seleccione un estado</option>
                                    <option ng-repeat="estado in listaEstados" value="{{estado.idestado}}">{{estado.nombre}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md4">
                                <label>Ciudad:</label>
                                <select id="cmbCiudad" ng-model="ubicacion.idciudad" class="form-control">
                                    <option value="">Seleccione una ciudad</option>
                                    <option ng-repeat="ciudad in listaCiudades" value="{{ciudad.idciudad}}">{{ciudad.nombre}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Teléfono:</label>
                                <input type="text" id="txtTelefono" ng-model="producto.telefono" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Correo:</label>
                                <input type="text" id="txtCorreo" ng-model="producto.correo" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Página Web:</label>
                                <input type="text" id="txtWeb" ng-model="producto.web" class="form-control" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Monto crédito:</label>
                                <input type="text" id="txtCredito" ng-model="producto.credito" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Días crédito:</label>
                                <input type="text" id="txtDiasCredito" ng-model="producto.diascredito" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Saldo:</label>
                                <input type="text" id="txtSaldo" ng-model="producto.saldo" class="form-control" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Banco:</label>
                                <input type="text" id="txtBanco" ng-model="producto.idbanco" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Cuenta:</label>
                                <input type="text" id="txtCuenta" ng-model="producto.cuenta" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>CLABE:</label>
                                <input type="text" id="txtClabe" ng-model="producto.clabe" class="form-control" />
                            </div>
                        </div>
                    </div>                        
                    <div class="modal-footer">
                        <button type="button" ng-click="Grabar()" class="btn btn-primary"><i class="fa fa-save"></i> Grabar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Producto -->

        <!-- Modal Eliminar-->
        <div id="modalProductoEliminar" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title" style="color:red;">¿Desea eliminar el proveedor?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>RFC:</label>
                                <input type="text" ng-model="producto.rfc" readonly="true" class="form-control" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Nombre comercial:</label>
                                <input type="text" ng-model="producto.nombrecomercial" readonly="true" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" ng-click="Eliminar()" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Eliminar-->
    </div>
    <!-- Referencias Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        // Código Javascript
        var myApp = angular.module('appCatalogos', []);

        myApp.controller('cProductos', function ($scope, $http) {
            $scope.listaPaises = [];
            $scope.listaEstados = [];
            $scope.listaCiudades = [];

            $scope.ubicacion = {idpais: "", idestado: "", idciudad: ""};

            // Obtener lista de países al cargar la página
            $http({
                method: "GET",
                url: 'cod-formulario-abc.php?functionToCall=obtener_paises'
            }).then(function (response) {
                $scope.listaPaises = response.data; // Asignar respuesta a listaPaises
            });

            // Función para manejar el cambio de país
            $scope.cambiarPais = function() {
                $scope.listaEstados = []; // Limpiar lista de estados
                $scope.listaCiudades = []; // Limpiar lista de ciudades
                if ($scope.ubicacion.idpais) {
                    // Obtener estados del país seleccionado
                    $http({
                        method: "POST",
                        url: 'cod-formulario-abc.php?functionToCall=obtener_estados',
                        data: {idpais: $scope.ubicacion.idpais}
                    }).then(function (response) {
                        $scope.listaEstados = response.data; // Asignar respuesta a listaEstados
                    });
                }
            };

            // Función para manejar el cambio de estado
            $scope.cambiarEstado = function() {
                $scope.listaCiudades = []; // Limpiar lista de ciudades
                if ($scope.ubicacion.idestado) {
                    // Obtener ciudades del estado seleccionado
                    $http({
                        method: "POST",
                        url: 'cod-formulario-abc.php?functionToCall=obtener_ciudades',
                        data: {idestado: $scope.ubicacion.idestado}
                    }).then(function (response) {
                        $scope.listaCiudades = response.data; // Asignar respuesta a listaCiudades
                    });
                }
            };

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
