var myApp = angular.module('appReportes', []);

myApp.controller('cReportes', function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];

    $scope.ubicacion = {
        idpais: null,
        idestado: null,
        idciudad: null
    }

    // Obtener lista de países al cargar la página
    $http({
        method: "POST",
        url: 'cod-reportes.php?functionToCall=obtener_paises',
    }).then(function (response) {
        $scope.listaPaises = response.data; // Asignar respuesta a listaPaises
        console.log("Paises:", $scope.listaPaises);
        
    }, function (error) {
        console.error("Error al obtener los países: ", error);
    });

    // Función para manejar el cambio de país
    $scope.cambiarPais = function() {
        $scope.listaEstados = []; // Limpiar lista de estados
        $scope.listaCiudades = []; // Limpiar lista de ciudades
        if ($scope.ubicacion.idpais) {
            // Obtener estados del país seleccionado
            $http({
                method: "POST",
                url: 'cod-reportes.php?functionToCall=obtener_estados',
                data: { idpais: $scope.ubicacion.idpais }
            }).then(function (response) {
                $scope.listaEstados = response.data; // Asignar respuesta a listaEstados
                console.log("Estados:", $scope.listaEstados)
                // Si ya se tiene un estado seleccionado, mantenerlo
                if ($scope.ubicacion.idestado) {
                    $scope.cambiarEstado();
                }
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
                url: 'cod-reportes.php?functionToCall=obtener_ciudades',
                data: { idestado: $scope.ubicacion.idestado }
            }).then(function (response) {
                $scope.listaCiudades = response.data; // Asignar respuesta a listaCiudades
                console.log("Ciudades:", $scope.listaCiudades)
            });
        }
    };

    // Función para obtener información completa del proveedor
    $scope.InfoProveedor = function (idproveedor) {
        //console.log('Id proveedor:', idproveedor);
        $http({
            method: "POST",
            url: 'cod-reportes.php?functionToCall=info_proveedor',
            data: { id_proveedor: idproveedor }
        }).then(function (response) {
            console.log('Información completa del proveedor:', response.data[0]); // Imprimir la información completa en la consola
            $scope.detalles_proveedor = response.data[0];
        }, function (error) {
            console.error('Error:', error);
        });
    };

    // Función para obtener información completa del proveedor
    $scope.InfoProveedor = function (idpais, idestado, idciudad) {
        // Verificar si algún ID es null y cambiarlo por 0
        idpais = idpais || 0;
        idestado = idestado || 0;
        idciudad = idciudad || 0;

        console.log("Ids:",idpais, idestado, idciudad);
        $http({
            method: "POST",
            url: 'cod-reportes.php?functionToCall=info_proveedor',
            data: { idpais: idpais, idestado: idestado, idciudad: idciudad }
        }).then(function (response) {
            console.log('Información completa del proveedor:', response.data); // Imprimir la información completa en la consola
            $scope.detalles_proveedor = response.data; // Asignar la información a detalles_proveedor
        }, function (error) {
            console.error('Error:', error);
        });
    };

    // Función para generar el reporte
    $scope.generarReporte = function() {
        $scope.InfoProveedor($scope.ubicacion.idpais, $scope.ubicacion.idestado, $scope.ubicacion.idciudad);
    };
});
