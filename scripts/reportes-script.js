var myApp = angular.module('appReportes', []);

myApp.controller('cReportes', function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];
    $scope.detalles_proveedor = [];

    $scope.ubicacion = {
        idpais: null,
        idestado: null,
        idciudad: null
    };

    // Obtener lista de países al cargar la página
    $http({
        method: "POST",
        url: 'cod-reportes.php?functionToCall=obtener_paises',
    }).then(function (response) {
        $scope.listaPaises = response.data;
    }, function (error) {
        console.error("Error al obtener los países: ", error);
    });

    $scope.cambiarPais = function() {
        $scope.listaEstados = [];
        $scope.listaCiudades = [];
        if ($scope.ubicacion.idpais) {
            $http({
                method: "POST",
                url: 'cod-reportes.php?functionToCall=obtener_estados',
                data: { idpais: $scope.ubicacion.idpais }
            }).then(function (response) {
                $scope.listaEstados = response.data;
                if ($scope.ubicacion.idestado) {
                    $scope.cambiarEstado();
                }
            });
        }
    };

    $scope.cambiarEstado = function() {
        $scope.listaCiudades = [];
        if ($scope.ubicacion.idestado) {
            $http({
                method: "POST",
                url: 'cod-reportes.php?functionToCall=obtener_ciudades',
                data: { idestado: $scope.ubicacion.idestado }
            }).then(function (response) {
                $scope.listaCiudades = response.data;
            });
        }
    };

    $scope.InfoProveedor = function (idpais, idestado, idciudad) {
        idpais = idpais || 0;
        idestado = idestado || 0;
        idciudad = idciudad || 0;

        console.log("Ids:", idpais, idestado, idciudad);

        $http({
            method: "POST",
            url: 'cod-reportes.php?functionToCall=info_proveedor',
            data: { idpais: idpais, idestado: idestado, idciudad: idciudad }
        }).then(function (response) {
            console.log('Información completa del proveedor:', response.data);
            $scope.detalles_proveedor = response.data.length ? response.data : [];
        }, function (error) {
            console.error('Error:', error);
            $scope.detalles_proveedor = [];
        });
    };

    $scope.generarReporte = function() {
        $scope.InfoProveedor($scope.ubicacion.idpais, $scope.ubicacion.idestado, $scope.ubicacion.idciudad);
    };

    $scope.descargarPDF = function() {
        var filtros = {
            pais: $scope.ubicacion.idpais ? ($scope.listaPaises.find(p => p.idpais === $scope.ubicacion.idpais) || {}).nombre || 'Todos' : 'Todos',
            estado: $scope.ubicacion.idestado ? ($scope.listaEstados.find(e => e.idestado === $scope.ubicacion.idestado) || {}).nombre || 'Todos' : 'Todos',
            ciudad: $scope.ubicacion.idciudad ? ($scope.listaCiudades.find(c => c.idciudad === $scope.ubicacion.idciudad) || {}).nombre || 'Todas' : 'Todas'
        };

        var data = {
            filtros: filtros,
            proveedores: $scope.detalles_proveedor
        };

        $http.post('generar_pdf.php', data, { responseType: 'arraybuffer' }).then(function (response) {
            var blob = new Blob([response.data], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'ReporteProveedores.pdf';
            link.click();
        }, function (error) {
            console.error('Error al generar el PDF:', error);
        });
    };
});
