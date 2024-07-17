var app = angular.module('appUsuarios', []);

app.controller('cUsuarios', function($scope, $http) {
    $scope.usuarios = [];
    $scope.nuevoUsuario = {};
    $scope.editarUsuarioData = {};

    // Cargar usuarios al iniciar la página
    $scope.cargarUsuarios = function() {
        $http.get('cod-usuarios.php?functionToCall=getUsuarios').then(function(response) {
            $scope.usuarios = response.data;
        });
    };

    // Registrar un nuevo usuario
    $scope.registrarUsuario = function() {
        $http.post('cod-usuarios.php?functionToCall=registrarUsuario', $scope.nuevoUsuario).then(function(response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $scope.cargarUsuarios();
                $scope.nuevoUsuario = {};
                $('#registroModal').modal('hide');
            } else {
                alert(response.data.message);
            }
        }, function(error) {
            console.error('Error:', error);
        });
    };

    // Abrir modal de registro de usuario
    $scope.abrirRegistroUsuarioModal = function() {
        $('#registroModal').modal('show');
    };

    // Editar usuario
    $scope.editarUsuario = function(usuario) {
        $scope.editarUsuarioData = angular.copy(usuario);
        $('#editarModal').modal('show');
    };

    // Actualizar contraseña
    $scope.actualizarContrasena = function() {
        $http.post('cod-usuarios.php?functionToCall=actualizarContrasena', $scope.editarUsuarioData).then(function(response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $('#editarModal').modal('hide');
                $scope.cargarUsuarios();
            } else {
                alert(response.data.message);
            }
        }, function(error) {
            console.error('Error:', error);
        });
    };

    // Eliminar usuario
    $scope.eliminarUsuario = function(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
            $http.post('cod-usuarios.php?functionToCall=eliminarUsuario', { id: id }).then(function(response) {
                if (response.data.status === "1") {
                    alert(response.data.message);
                    $scope.cargarUsuarios();
                } else {
                    alert(response.data.message);
                }
            }, function(error) {
                console.error('Error:', error);
            });
        }
    };

    // Inicializar la lista de usuarios
    $scope.cargarUsuarios();
});
