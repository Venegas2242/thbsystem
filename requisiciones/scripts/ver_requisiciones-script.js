// Definir el módulo de AngularJS
var appRequisicion = angular.module("appRequisicion", []);

appRequisicion.controller("verRequisicionesCtrl", function ($scope, $http) {
    $scope.requisiciones = [];
    $scope.mostrarTodo = esAdmin; // Si es admin, comienza mostrando todas las requisiciones

    $scope.obtenerRequisiciones = function (mostrarTodo, idUsuario) {
        mostrarTodo = mostrarTodo ? 1 : 0;
        console.log("Obteniendo requisiciones. Mostrar todo:", mostrarTodo);
        $http({
            method: "GET",
            url: "cod-requisicion.php",
            params: {
                functionToCall: "obtener_requisiciones",
                mostrarTodo: mostrarTodo,
                idusuario: idUsuario
            }
        }).then(function (response) {
            console.log("Respuesta recibida:", response.data);
            $scope.requisiciones = response.data;
        }, function (error) {
            console.error("Error al cargar las requisiciones: ", error);
        });
    };

    // Cargar las requisiciones al inicio
    $scope.obtenerRequisiciones($scope.mostrarTodo, idUsuario);
});
