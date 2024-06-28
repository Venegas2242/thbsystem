var myApp = angular.module('appCatalogos', []);

myApp.controller('cProveedores', function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];

    // Inicializar proveedor
    $scope.proveedor = {
        idproveedor: 0,
        nombrecomercial: "",
        nombrecomun: "",
        direccion: "",
        idciudad: 0,
        idestado: 0,
        idpais: 0,
        rfc: "",
        telefono: "",
        correo: "",
        web: "",
        credito: 0,
        saldo: 0,
        diascredito: 0,
        idbanco: "",
        cuenta: "",
        clabe: ""
    };

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
        if ($scope.proveedor.idpais) {
            // Obtener estados del país seleccionado
            $http({
                method: "POST",
                url: 'cod-proveedores.php?functionToCall=obtener_estados',
                data: { idpais: $scope.proveedor.idpais }
            }).then(function (response) {
                $scope.listaEstados = response.data; // Asignar respuesta a listaEstados
            });
        }
    };

    // Función para manejar el cambio de estado
    $scope.cambiarEstado = function() {
        $scope.listaCiudades = []; // Limpiar lista de ciudades
        if ($scope.proveedor.idestado) {
            // Obtener ciudades del estado seleccionado
            $http({
                method: "POST",
                url: 'cod-proveedores.php?functionToCall=obtener_ciudades',
                data: { idestado: $scope.proveedor.idestado }
            }).then(function (response) {
                $scope.listaCiudades = response.data; // Asignar respuesta a listaCiudades
            });
        }
    };

    var myData = { textoBuscar: '' };

    // Obtener lista de proveedores al cargar la página
    $http({
        method: "POST",
        url: 'cod-proveedores.php?functionToCall=buscar_proveedor',
        data: myData
    }).then(function (response) {
        $scope.listaProveedores = response.data;
    });

    // Función para buscar proveedor por texto
    $scope.BuscarProveedor = function () {
        var myData = { textoBuscar: String($("#txtTextoBuscar").val()) };
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=buscar_proveedor',
            data: myData
        }).then(function (response) {
            $scope.listaProveedores = response.data;
        });
    };

    // Función para abrir el modal de edición de proveedor
    $scope.AbrirEditar = function (item) {
        console.log('Item:', item); // Imprimir el objeto completo en la consola
        $scope.proveedor = item;
        $("#modalProveedor").modal();
    };

    // Función para abrir el modal de nuevo proveedor
    $scope.AbrirNuevo = function () {
        $scope.proveedor = {
            idproveedor: 0,
            nombrecomercial: "",
            nombrecomun: "",
            direccion: "",
            idciudad: 0,
            idestado: 0,
            idpais: 0,
            rfc: "",
            telefono: "",
            correo: "",
            web: "",
            credito: 0,
            saldo: 0,
            diascredito: 0,
            idbanco: "",
            cuenta: "",
            clabe: ""
        };
        $("#modalProveedorNuevo").modal();
    };

    // Función para guardar proveedor
    $scope.Grabar = function () {
        console.log('Datos del proveedor:', $scope.proveedor);

        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=grabar_proveedor',
            data: $scope.proveedor
        }).then(function (response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $scope.BuscarProveedor();
                $("#modalProveedorNuevo").modal("hide");
            } else {
                alert(response.data.message);
            }
        }, function (error) {
            console.error('Error:', error);
        });
    };

    // Función para abrir el modal de eliminación de proveedor
    $scope.AbrirEliminar = function (item) {
        $scope.proveedor = item;
        $("#modalProveedorEliminar").modal();
    };

    // Función para eliminar proveedor
    $scope.Eliminar = function () {
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=eliminar_proveedor',
            data: $scope.proveedor
        }).then(function (response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $scope.BuscarProveedor();
                $("#modalProveedorEliminar").modal("hide");
            } else {
                alert(response.data.message);
            }
        });
    };
});