var app = angular.module('appBancos', []);

app.controller('cBancos', function($scope, $http) {
    $scope.bancos = [];
    $scope.nuevoBanco = {};
    $scope.editarBancoData = {};

    // Cargar bancos al iniciar la página
    $scope.cargarBancos = function() {
        $http.get('cod-bancos.php?functionToCall=getBancos').then(function(response) {
            $scope.bancos = response.data;
        });
    };

    // Registrar un nuevo banco
    $scope.registrarBanco = function() {
        $http.post('cod-bancos.php?functionToCall=registrarBanco', $scope.nuevoBanco).then(function(response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $scope.cargarBancos();
                $scope.nuevoBanco = {};
                $('#registroModal').modal('hide');
            } else {
                alert(response.data.message);
            }
        }, function(error) {
            console.error('Error:', error);
        });
    };

    // Abrir modal de registro de banco
    $scope.abrirRegistroBancoModal = function() {
        $('#registroModal').modal('show');
    };

    // Editar banco
    $scope.editarBanco = function(banco) {
        $scope.editarBancoData = angular.copy(banco);
        $('#editarModal').modal('show');
    };

    // Actualizar banco
    $scope.actualizarBanco = function() {
        $http.post('cod-bancos.php?functionToCall=actualizarBanco', $scope.editarBancoData).then(function(response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $('#editarModal').modal('hide');
                $scope.cargarBancos();
            } else {
                alert(response.data.message);
            }
        }, function(error) {
            console.error('Error:', error);
        });
    };

    // Eliminar banco
    $scope.eliminarBanco = function(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este banco?')) {
            $http.post('cod-bancos.php?functionToCall=eliminarBanco', { id: id }).then(function(response) {
                if (response.data.status === "1") {
                    alert(response.data.message);
                    $scope.cargarBancos();
                } else {
                    alert(response.data.message);
                }
            }, function(error) {
                console.error('Error:', error);
            });
        }
    };

    // Inicializar la lista de bancos
    $scope.cargarBancos();
});
