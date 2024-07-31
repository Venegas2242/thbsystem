var appRequisicion = angular.module("appRequisicion", []);

appRequisicion.controller("cRequisicion", function ($scope, $http) {
  $scope.listaUnidades = [];
  $scope.sugerencias = [];
  $scope.textoBuscar = "";
  $scope.requisicion = {};
  $scope.articulosSeleccionados = [];
  $scope.articuloValido = false;

  $scope.obtenerUnidades = function (idUnidad) {
    $http({
      method: "GET",
      url: "cod-requisicion.php",
      params: {
        functionToCall: "obtener_unidades",
        idUnidad: idUnidad,
      },
    }).then(function (response) {
      $scope.listaUnidades = response.data; // Asignar respuesta a listaUnidades
    });
  };

  $scope.BuscarProducto = function () {
    $scope.articuloValido = false;
    if ($scope.textoBuscar.length > 2) {
      $http({
        method: "GET",
        url: "cod-requisicion.php",
        params: {
          functionToCall: "buscar_productos",
          textoBuscar: $scope.textoBuscar,
        },
      }).then(function (response) {
        $scope.sugerencias = response.data;
        $scope.articuloValido = $scope.sugerencias.some(
          (s) => s.descripcion === $scope.textoBuscar
        );
      });
    } else {
      $scope.sugerencias = [];
    }
  };

  $scope.SeleccionarProducto = function (producto) {
    $scope.textoBuscar = producto.descripcion;
    $scope.sugerencias = [];
    $scope.articuloValido = true;
  };

  $scope.AgregarDatos = function (form) {
    if (form.$valid && $scope.articuloValido) {
      var almacenSeleccionado =
        document.getElementById("almacen").options[
          document.getElementById("almacen").selectedIndex
        ].text;
      var unidadSeleccionada =
        document.getElementById("unidad").options[
          document.getElementById("unidad").selectedIndex
        ].text;
      var usoSeleccionado =
        document.getElementById("uso").options[
          document.getElementById("uso").selectedIndex
        ].text;

      $scope.articulosSeleccionados.push({
        almacen: almacenSeleccionado,
        articulo: $scope.textoBuscar,
        unidad: unidadSeleccionada,
        cantidad: $scope.requisicion.cantidad,
        uso: usoSeleccionado,
        fecha: $scope.requisicion.fecha,
      });

      $scope.requisicion = {};
      $scope.textoBuscar = "";
      $scope.articuloValido = false;
    } else {
      var mensajeError = "";

      if (!form.fecha.$valid) {
        mensajeError = "Selecciona una fecha.";
      } else if (!form.articulo.$valid || !$scope.articuloValido) {
        mensajeError = "Selecciona un artículo válido de la lista.";
      } else {
        mensajeError = "Por favor, completa todos los campos requeridos.";
      }

      var alerta = document.createElement("div");
      alerta.className = "alert alert-danger";
      alerta.innerText = mensajeError;
      document.body.appendChild(alerta);

      setTimeout(function () {
        alerta.remove();
      }, 3000);
    }
  };

  $scope.QuitarArticulo = function (index) {
    $scope.articulosSeleccionados.splice(index, 1);
  };

  $scope.MostrarNotificacion = function (mensaje) {
    document.getElementById("mensajeNotificacion").innerText = mensaje;
    $("#modalNotificacion").modal();
  };

  $scope.obtenerUnidades();

  // Inicializar Flatpickr
  $(document).ready(function () {
    $(".datepicker").flatpickr({
      dateFormat: "d/m/Y",
      locale: "es",
      theme: "material_blue",
    });
  });
});
