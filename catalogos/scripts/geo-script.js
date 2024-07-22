angular
  .module("geoApp", [])
  .controller("GeoController", function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];

    $scope.entidad = { idpais: null, idestado: null };

    $scope.editar = {};

    $scope.estado_nuevo = "";
    $scope.pais_nuevo = "";
    $scope.ciudad_nueva = "";
    $scope.errorMessage = "";

    $scope.showPage = function (pageId) {
      $scope.activePage = pageId; // Establece la página activa
      $scope.resetSelections(); // Resetea las selecciones al cambiar de página
      $scope.cargarPaises();
      $scope.errorMessage = ""; // Limpiar el mensaje de error al cambiar de página
    };

    $scope.cargarPaises = function () {
      $scope.listaPaises = [];
      $scope.listaEstados = [];
      $scope.listaCiudades = [];

      $http({
        method: "POST",
        url: "cod-geo.php?functionToCall=obtener_paises",
      }).then(
        function (response) {
          $scope.listaPaises = response.data;
        },
        function (error) {
          console.error("Error al cargar los países:", error);
        }
      );
    };

    $scope.cambiarPais = function () {
      // if ($scope.entidad.idpais == "") {

      // } else {
      $http({
        method: "POST",
        url: "cod-geo.php?functionToCall=obtener_estados",
        data: { idpais: $scope.entidad.idpais },
      }).then(
        function (response) {
          if (response.data.length === 0) {
            $scope.listaEstados = [{ nombre: "Sin estados" }];
          } else {
            $scope.listaEstados = response.data;
            $scope.entidad.idestado = null;
            $scope.cambiarEstado();
            console.log("Cambio de pais:", $scope.entidad);
          }
        },
        function (error) {
          console.error("Error al cargar los estados:", error);
        }
      );
      // }
    };

    $scope.cambiarEstado = function () {
      console.log("Cambio de estado:", $scope.entidad);
      if (
        $scope.entidad.idpais == "" ||
        $scope.entidad.idestado == "" ||
        $scope.entidad.idestado == null
      ) {
        $scope.listaCiudades = [];
      } else {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=obtener_ciudades",
          data: {
            idestado: $scope.entidad.idestado,
          },
        }).then(
          function (response) {
            if (response.data.length === 0) {
              $scope.listaCiudades = [{ nombre: "Sin ciudades" }];
            } else {
              $scope.listaCiudades = response.data;
            }
          },
          function (error) {
            console.error("Error al cargar las ciudades:", error);
          }
        );
      }
    };

    $scope.selectPais = function (pais) {
      $scope.entidad.idpais = pais.idpais;
      $scope.cambiarPais();
    };

    $scope.selectEstado = function (estado) {
      $scope.entidad.idestado = estado.idestado;
      $scope.cambiarEstado();
    };

    $scope.resetSelections = function () {
      $scope.entidad.idpais = null;
      $scope.entidad.idestado = null;
    };

    function isValidName(name) {
      const regex = /^[A-Za-z][A-Za-z\s]*$/;
      return regex.test(name);
    }

    $scope.registrarPais = function () {
      if (isValidName($scope.pais_nuevo)) {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=registrar_pais",
          data: { pais_nuevo: $scope.pais_nuevo },
        }).then(
          function () {
            $scope.cargarPaises();
            $scope.pais_nuevo = "";
            $scope.errorMessage = "";
          },
          function (error) {
            $scope.errorMessage = "Error al registrar el país.";
            console.error("Error:", error);
          }
        );
      } else {
        $scope.errorMessage = "El nombre del país no es válido.";
      }
    };

    $scope.registrarEstado = function () {
      if (isValidName($scope.estado_nuevo)) {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=registrar_estado",
          data: {
            idpais: $scope.entidad.idpais,
            estado_nuevo: $scope.estado_nuevo,
          },
        }).then(
          function (response) {
            $scope.cambiarPais();
            $scope.estado_nuevo = "";
            $scope.errorMessage = "";
          },
          function (error) {
            $scope.errorMessage = "Error al registrar el estado.";
            console.error("Error al registrar el estado:", error);
          }
        );
      } else {
        $scope.errorMessage = "El nombre del estado no es válido.";
      }
    };

    $scope.registrarCiudad = function () {
      if (isValidName($scope.ciudad_nueva)) {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=registrar_ciudad",
          data: {
            idestado: $scope.entidad.idestado,
            ciudad_nueva: $scope.ciudad_nueva,
          },
        }).then(
          function (response) {
            $scope.cambiarEstado();
            $scope.ciudad_nueva = "";
            $scope.errorMessage = "";
          },
          function (error) {
            $scope.errorMessage = "Error al registrar la ciudad.";
            console.error("Error al registrar la ciudad:", error);
          }
        );
      } else {
        $scope.errorMessage = "El nombre de la ciudad no es válido.";
      }
    };

    // Controlador de actualización
    $scope.actualizarUbicacion = function () {
      if ($scope.editar.tipo == 0) {
        $scope.actualizarPais();
      } else if ($scope.editar.tipo == 1) {
        $scope.actualizarEstado();
      } else {
        $scope.actualizarCiudad();
      }
    };

    // Editar Pais
    $scope.editPais = function (pais) {
      pais.tipo = 0;
      $scope.editar = angular.copy(pais);
      $("#editarUbicacionModal").modal("show");
    };

    $scope.actualizarPais = function () {
      $http
        .post("cod-geo.php?functionToCall=actualizar_pais", $scope.editar)
        .then(
          function (response) {
            $("#editarUbicacionModal").modal("hide");
            $scope.cargarPaises();
          },
          function (error) {
            console.error("Error:", error);
          }
        );
    };

    $scope.deletePais = function (pais) {
      console.log("Id: " + pais.idpais + ". Pais: " + pais.nombre);

      if (confirm("¿Está seguro de que desea eliminar " + pais.nombre + "?")) {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=eliminar_pais",
          data: { idpais: pais.idpais },
        }).then(
          function (response) {
            if (response.data.status == "1") {
              // Recargar los contactos del entidad
              $scope.cargarPaises();
            } else {
              console.error("Error al eliminar país:", response.data.message);
            }
          },
          function (error) {
            console.error("Error al eliminar país:", error);
          }
        );
      }
    };

    $scope.editEstado = function (estado) {
      estado.tipo = 1;
      $scope.editar = angular.copy(estado);
      console.log("Modal estado:", $scope.editar);
      $("#editarUbicacionModal").modal("show");
    };

    $scope.actualizarEstado = function () {
      console.log("Editando estado:", $scope.editar);
      $http
        .post("cod-geo.php?functionToCall=actualizar_estado", $scope.editar)
        .then(
          function (response) {
            $("#editarUbicacionModal").modal("hide");
            $scope.cambiarPais();
          },
          function (error) {
            console.error("Error:", error);
          }
        );
    };

    $scope.deleteEstado = function (estado) {
      console.log("Id: " + estado.idestado + ". Estado: " + estado.nombre);

      if (
        confirm("¿Está seguro de que desea eliminar " + estado.nombre + "?")
      ) {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=eliminar_estado",
          data: { idestado: estado.idestado },
        }).then(
          function (response) {
            if (response.data.status == "1") {
              // Recargar los contactos del entidad
              $scope.cambiarPais();
            } else {
              console.error("Error al eliminar estado:", response.data.message);
            }
          },
          function (error) {
            console.error("Error al eliminar estado:", error);
          }
        );
      }
    };

    $scope.editCiudad = function (ciudad) {
      ciudad.tipo = 2;
      $scope.editar = angular.copy(ciudad);
      console.log("Modal estado:", $scope.editar);
      $("#editarUbicacionModal").modal("show");
    };

    $scope.actualizarCiudad = function () {
      $http
        .post("cod-geo.php?functionToCall=actualizar_ciudad", $scope.editar)
        .then(
          function (response) {
            $("#editarUbicacionModal").modal("hide");
            $scope.cambiarEstado();
          },
          function (error) {
            console.error("Error:", error);
          }
        );
    };

    $scope.deleteCiudad = function (ciudad) {
      console.log("Id: " + ciudad.idciudad + ". Ciudad: " + ciudad.nombre);

      if (
        confirm("¿Está seguro de que desea eliminar " + ciudad.nombre + "?")
      ) {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=eliminar_ciudad",
          data: { idciudad: ciudad.idciudad },
        }).then(
          function (response) {
            if (response.data.status == "1") {
              // Recargar los contactos del entidad
              $scope.cambiarEstado();
            } else {
              console.error("Error al eliminar ciudad:", response.data.message);
            }
          },
          function (error) {
            console.error("Error al eliminar ciudad:", error);
          }
        );
      }
    };

    $scope.showPage("Paises");
  });
