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

    $scope.showPage = function (pageId) {
      const pages = document.querySelectorAll(".content");
      pages.forEach((page) => {
        page.classList.remove("active");
      });

      document.getElementById(pageId).classList.add("active");

      $scope.cargarPaises();
    };

    // Cargar paises inicialmente
    $scope.cargarPaises = function () {
      $scope.listaPaises = []; // Limpiar lista de paises
      $scope.listaEstados = []; // Limpiar lista de estados
      $scope.listaCiudades = []; // Limpiar lista de ciudades

      $http({
        method: "POST",
        url: "cod-geo.php?functionToCall=obtener_paises",
      }).then(
        function (response) {
          $scope.listaPaises = response.data;
          console.log("Paises cargados: ", $scope.listaPaises); // Ver datos cargados
        },
        function (error) {
          console.error("Error al cargar los países:", error);
        }
      );
    };

    // Función para manejar el cambio de país y cargar estados
    $scope.cambiarPais = function () {
      console.log("entidad:", $scope.entidad.idpais);
      if ($scope.entidad.idpais == "") {
        $scope.listaEstados = [];
      } else {
        $http({
          method: "POST",
          url: "cod-geo.php?functionToCall=obtener_estados",
          data: { idpais: $scope.entidad.idpais },
        }).then(
          function (response) {
            console.log("Respuesta: ", response);
            // Verificar si la respuesta está vacía y ajustar la lista de estados
            if (response.data.length === 0) {
              // Si no hay estados, añadir un elemento que indica "Sin estados"
              $scope.listaEstados = [{ nombre: "Sin estados" }];
            } else {
              $scope.listaEstados = response.data;
            }
            console.log("Estados cargados:", $scope.listaEstados);
          },
          function (error) {
            console.error("Error al cargar los estados:", error);
          }
        );
      }
    };

    // Función para manejar el cambio de estados y cargar ciudades
    $scope.cambiarEstado = function () {
      console.log("entidad:", $scope.entidad);
      if ($scope.entidad.idpais == "" || $scope.entidad.idestado == "") {
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
          // Verificar si la respuesta está vacía y ajustar la lista de estados
          if (response.data.length === 0) {
            // Si no hay ciudades, añadir un elemento que indica "Sin estados"
            $scope.listaCiudades = [{ nombre: "Sin ciudades" }];
          } else {
            $scope.listaCiudades = response.data;
          }
          console.log("Ciudades cargadas:", $scope.listaCiudades);
        },
        function (error) {
          console.error("Error al cargar las ciudades:", error);
        }
      );
    }
    };

    $scope.registrarPais = function () {
      console.log("Pais a registrar:", $scope.pais_nuevo);

      $http({
        method: "POST",
        url: "cod-geo.php?functionToCall=registrar_pais",
        data: { pais_nuevo: $scope.pais_nuevo },
      }).then(
        function () {
          $scope.cargarPaises();
          $scope.pais_nuevo = "";
        },
        function (error) {
          console.error("Error:", error);
        }
      );
    };

    // Función para registrar un nuevo estado
    $scope.registrarEstado = function () {
      console.log("Pais seleccionado:", $scope.entidad.idpais);
      console.log("Estado nuevo:", $scope.estado_nuevo);

      $http({
        method: "POST",
        url: "cod-geo.php?functionToCall=registrar_estado",
        data: {
          idpais: $scope.entidad.idpais,
          estado_nuevo: $scope.estado_nuevo,
        },
      }).then(
        function (response) {
          $scope.cambiarPais(); // Recargar estados después de registrar uno nuevo
          $scope.estado_nuevo = "";
        },
        function (error) {
          console.error("Error al registrar el estado:", error);
        }
      );
    };

    // Función para registrar un nuevo estado
    $scope.registrarCiudad = function () {
      console.log("Estado seleccionado:", $scope.entidad.idestado);
      console.log("Ciudad nueva:", $scope.ciudad_nueva);

      $http({
        method: "POST",
        url: "cod-geo.php?functionToCall=registrar_ciudad",
        data: {
          idestado: $scope.entidad.idestado,
          ciudad_nueva: $scope.ciudad_nueva,
        },
      }).then(
        function (response) {
          $scope.cambiarEstado(); // Recargar estados después de registrar uno nuevo
          $scope.ciudad_nueva = "";
        },
        function (error) {
          console.error("Error al registrar el estado:", error);
        }
      );
    };
  });
