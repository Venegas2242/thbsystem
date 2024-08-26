var app = angular.module("appUsuarios", []);

app.controller("cUsuarios", function ($scope, $http) {
  $scope.usuarios = [];
  $scope.nuevoUsuario = {};
  $scope.editarUsuarioData = {};

  // Cargar usuarios al iniciar la página
  $scope.cargarUsuarios = function () {
    $http
      .get("cod-usuarios.php?functionToCall=getUsuarios")
      .then(function (response) {
        $scope.usuarios = response.data;
        console.log("Usuarios cargados: ", $scope.usuarios);
      });
  };

  // Registrar un nuevo usuario
  $scope.registrarUsuario = function () {
    console.log("Nuevo usuario: ", $scope.nuevoUsuario);
    $http
      .post(
        "cod-usuarios.php?functionToCall=registrarUsuario",
        $scope.nuevoUsuario
      )
      .then(
        function (response) {
            console.log("response", response);
          if (response.data.status === "1") {
            alert(response.data.message);
            $scope.cargarUsuarios();
            $scope.nuevoUsuario = {};
            $("#registroModal").modal("hide");
          } else {
            alert(response.data.message);
          }
        },
        function (error) {
          console.error("Error:", error);
        }
      );
  };

  // Abrir modal de registro de usuario
  $scope.abrirRegistroUsuarioModal = function () {
    $("#registroModal").modal("show");
  };

  // Editar usuario
  $scope.editarUsuario = function (usuario) {
    $scope.editarUsuarioData = angular.copy(usuario);
    $("#editarModal").modal("show");
  };

  // Actualizar contraseña
  $scope.actualizarContrasena = function () {
    console.log("Datos del usuario a editar: ", $scope.editarUsuarioData);

    $http
      .post(
        "cod-usuarios.php?functionToCall=actualizarContrasena",
        $scope.editarUsuarioData
      )
      .then(
        function (response) {
          if (response.data.status === "1") {
            alert(response.data.message);
            $("#editarModal").modal("hide");
            $scope.cargarUsuarios();
          } else {
            alert(response.data.message);
          }
        },
        function (error) {
          console.error("Error:", error);
        }
      );
  };

  $scope.eliminarUsuario = function (id) {
    $scope.usuarioAEliminar = id; // Almacenar el ID del usuario a eliminar
    $("#modalEliminarUsuario").modal("show"); // Mostrar el modal de confirmación
  };

  $scope.confirmarEliminarUsuario = function () {
    $("#modalEliminarUsuario").modal("hide"); // Ocultar el modal de confirmación

    $http
      .post("cod-usuarios.php?functionToCall=eliminarUsuario", {
        id: $scope.usuarioAEliminar,
      })
      .then(
        function (response) {
          if (response.data.status === "1") {
            $scope.MostrarNotificacion("Éxito", response.data.message, true);
          } else {
            $scope.MostrarNotificacion("Error", response.data.message, false);
          }
        },
        function (error) {
          console.error("Error:", error);
          $scope.MostrarNotificacion(
            "Error",
            "Hubo un problema al intentar eliminar el usuario.",
            false
          );
        }
      );
  };

  $scope.MostrarNotificacion = function (encabezado, mensaje, b_recargar) {
    $("#modalNotificacion .modal-title").text(encabezado);
    $("#modalNotificacion .modal-body").text(mensaje);
    $("#modalNotificacion").modal("show");
    $scope.recargar = b_recargar; // Usar $scope para almacenar la variable
  };

  $scope.CerrarNotificacion = function () {
    $("#modalNotificacion").modal("hide");
    if ($scope.recargar) {
      window.location.reload();
    }
  };

  // Inicializar la lista de usuarios
  $scope.cargarUsuarios();
});
