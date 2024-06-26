var myApp = angular.module('appCatalogos', []);

myApp.controller('cProductos', function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];

    $scope.ubicacion = {idpais: "", idestado: "", idciudad: ""};

    // Obtener lista de países al cargar la página
    $http({
        method: "GET",
        url: 'cod-proveedores.php?functionToCall=obtener_paises'
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
                url: 'cod-proveedores.php?functionToCall=obtener_estados',
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
                url: 'cod-proveedores.php?functionToCall=obtener_ciudades',
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
        url: 'cod-proveedores.php?functionToCall=buscar_producto',
        data: myData}).then(function (response) {
        $scope.listaProductos = response.data;
    });

    $scope.BuscarProducto = function () {
        var myData = {textoBuscar: String($("#txtTextoBuscar").val())};
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=buscar_producto',
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
            url: 'cod-proveedores.php?functionToCall=grabar_producto',
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
            url: 'cod-proveedores.php?functionToCall=eliminar_producto',
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