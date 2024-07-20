var myApp = angular.module('appReportes', []);

myApp.controller('cReportes', function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];
    $scope.detalles_entidad = [];

    $scope.ubicacion = {
        idpais: null,
        idestado: null,
        idciudad: null,
        tipo: null // Cambiar activo a tipo
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

    $scope.InfoEntidad = function (idpais, idestado, idciudad, tipo) {
        idpais = idpais || 0;
        idestado = idestado || 0;
        idciudad = idciudad || 0;
        tipo = tipo || 'Proveedor'; // Si tipo no está definido, usar 'Proveedor' por defecto

        console.log("Ids:", idpais, idestado, idciudad, "->", tipo, "<-");

        $http({
            method: "POST",
            url: 'cod-reportes.php?functionToCall=info_entidad',
            data: { idpais: idpais, idestado: idestado, idciudad: idciudad, tipo: tipo }
        }).then(function (response) {
            console.log('Información completa de la entidad:', response.data);
            $scope.detalles_entidad = response.data.length ? response.data : [];
        }, function (error) {
            console.error('Error:', error);
            $scope.detalles_entidad = [];
        });
    };

    $scope.generarReporte = function() {
        $scope.InfoEntidad($scope.ubicacion.idpais, $scope.ubicacion.idestado, $scope.ubicacion.idciudad, $scope.ubicacion.tipo);
    };

    $scope.descargarPDF = function() {
        var tipo = $scope.ubicacion.tipo || "Proveedor";
    
        var data = {
            proveedores: $scope.detalles_entidad,
            tipo: tipo
        };
    
        console.log("Tipo:", tipo);
    
        $http.post('generar_pdf.php', data, { responseType: 'arraybuffer' }).then(function (response) {
            var blob = new Blob([response.data], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'Reporte' + tipo + '.pdf';
            link.click();
        }, function (error) {
            console.error('Error al generar el PDF:', error);
        });
    };
    
});
