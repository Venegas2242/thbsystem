angular
  .module("geoApp", [])
  .controller("GeoController", function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];

    $scope.entidad = { idpais: null, idestado: null };

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
      if ($scope.entidad.idpais == "") {
        $scope.listaEstados = [];
      } else {
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
            }
          },
          function (error) {
            console.error("Error al cargar los estados:", error);
          }
        );
      }
    };

    $scope.cambiarEstado = function () {
      if ($scope.entidad.idpais == "" || $scope.entidad.idestado == "" || $scope.entidad.idestado == null) {
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

    $scope.selectPais = function(pais) {
      $scope.entidad.idpais = pais.idpais;
      $scope.cambiarPais();
    };

    $scope.selectEstado = function(estado) {
      $scope.entidad.idestado = estado.idestado;
      $scope.cambiarEstado();
    };

    $scope.resetSelections = function() {
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

    // Funciones de edición y eliminación
    $scope.editPais = function(pais) {
      // Aquí agregas la lógica para editar el país
      alert("Editando país: " + pais.nombre);
    };

    $scope.deletePais = function(pais) {
      // Aquí agregas la lógica para eliminar el país
      alert("Eliminando país: " + pais.nombre);
    };

    $scope.editEstado = function(estado) {
      // Aquí agregas la lógica para editar el estado
      alert("Editando estado: " + estado.nombre);
    };

    $scope.deleteEstado = function(estado) {
      // Aquí agregas la lógica para eliminar el estado
      alert("Eliminando estado: " + estado.nombre);
    };

    $scope.editCiudad = function(ciudad) {
      // Aquí agregas la lógica para editar la ciudad
      alert("Editando ciudad: " + ciudad.nombre);
    };

    $scope.deleteCiudad = function(ciudad) {
      // Aquí agregas la lógica para eliminar la ciudad
      alert("Eliminando ciudad: " + ciudad.nombre);
    };

    $scope.showPage('Paises');
  });
