var appProductos = angular.module("appProductos", []);

appProductos.controller("cProductos", function ($scope, $http) {
  $scope.listaProductos = [];
  $scope.listaUnidades = [];
  $scope.listaGrupos = [];
  $scope.listaProveedores = [];
  $scope.listaTipos = [];

  // Inicializar producto
  $scope.producto = {
    idproducto: 0,
    codigo: "",
    descripcion: "",
    ubicacion: "",
    costo: 0,
    codigobarras: "",
    idunidad: null,
    idgrupoproducto: null,
    idproveedor: null,
    idtipoproducto: null,
  };

  // Obtener lista de productos al cargar la página
  $scope.iniciarSeccion = function () {
    $http({
      method: "GET",
      url: "cod-productos.php?functionToCall=obtener_productos",
    }).then(function (response) {
      $scope.listaProductos = response.data; // Asignar respuesta a listaProductos
    });
  };

  $scope.iniciarSeccion();

  $scope.obtenerUnidades = function (idUnidad) {
    $http({
      method: "GET",
      url: "cod-productos.php",
      params: {
        functionToCall: "obtener_unidades",
        idUnidad: idUnidad,
      },
    }).then(function (response) {
      $scope.listaUnidades = response.data; // Asignar respuesta a listaUnidades
    });
  };

  $scope.obtenerGrupos = function (idGrupo) {
    $http({
      method: "GET",
      url: "cod-productos.php",
      params: {
        functionToCall: "obtener_grupos",
        idGrupo: idGrupo,
      },
    }).then(function (response) {
      $scope.listaGrupos = response.data; // Asignar respuesta a listaGrupos
    });
  };

  $scope.obtenerTipos = function (idTipo) {
    $http({
      method: "GET",
      url: "cod-productos.php",
      params: {
        functionToCall: "obtener_tipos",
        idTipo: idTipo,
      },
    }).then(function (response) {
      $scope.listaTipos = response.data; // Asignar respuesta a listaTipos
    });
  };

  // Obtener lista de proveedores
  $scope.obtenerProveedores = function (idProveedor) {
    $http({
      method: "GET",
      url: "cod-productos.php",
      params: {
        functionToCall: "obtener_proveedores",
        idProveedor: idProveedor,
      },
    }).then(function (response) {
      $scope.listaProveedores = response.data; // Asignar respuesta a listaProveedores
    });
  };

  // Obtener lista inicial de proveedores
  $scope.obtenerUnidades(null);
  $scope.obtenerGrupos(null);
  $scope.obtenerTipos(null);
  $scope.obtenerProveedores(null);

  $scope.BuscarProducto = function () {
    var textoBuscar = $("#txtTextoBuscar").val();
    var myData = { textoBuscar: textoBuscar };
    $http({
      method: "POST",
      url: "cod-productos.php?functionToCall=buscar_producto",
      data: myData,
    }).then(function (response) {
      $scope.listaProductos = response.data;
      console.log("Respuesta:", $scope.listaProductos);
    });
  };

  // Función para abrir el modal de edición de producto
  $scope.AbrirEditar = function (item) {
    $scope.producto = angular.copy(item);
    $scope.obtenerProveedores($scope.producto.idproveedor); // Actualizar la lista de proveedores
    $scope.obtenerUnidades($scope.producto.idunidad); // Actualizar la lista de unidades
    $scope.obtenerGrupos($scope.producto.idgrupoproducto); // Actualizar la lista de grupos
    $scope.obtenerTipos($scope.producto.idtipoproducto); // Actualizar la lista de tipos
    $("#modalProductoEditar").modal();
  };

  // Función para abrir el modal de nuevo producto
  $scope.AbrirNuevo = function () {
    $scope.producto = {
      idproducto: 0,
      codigo: "",
      descripcion: "",
      ubicacion: "",
      costo: 0,
      codigobarras: "",
      idunidad: null,
      idgrupoproducto: null,
      idproveedor: null,
      idtipoproducto: null,
    };
    $scope.obtenerProveedores(null); // Obtener la lista inicial de proveedores
    $scope.obtenerUnidades(null); // Obtener la lista inicial de unidades
    $scope.obtenerGrupos(null); // Obtener la lista inicial de grupos
    $scope.obtenerTipos(null); // Obtener la lista inicial de tipos
    $("#modalProductoNuevo").modal();
  };

  // Función para guardar producto
  $scope.Grabar = function () {
    console.log("Se grabará:", $scope.producto);
    $http({
      method: "POST",
      url: "cod-productos.php?functionToCall=grabar_producto",
      data: $scope.producto,
    }).then(
      function (response) {
        console.log("Respuesta:", response);
        if (response.data.status === "1") {
          alert(response.data.message);
          $scope.iniciarSeccion();
          $("#modalProductoNuevo").modal("hide");
          $("#modalProductoEditar").modal("hide");
        } else {
          console.log("Error 1");
          alert(response.data.message);
        }
      },
      function (error) {
        console.log("Error 2");
        console.error("Error:", error);
      }
    );
  };

  // Función para abrir el modal de eliminación de producto
  $scope.AbrirEliminar = function (item) {
    $scope.producto = item;
    $("#modalProductoEliminar").modal();
  };

  // Función para eliminar producto
  $scope.Eliminar = function () {
    $http({
      method: "POST",
      url: "cod-productos.php?functionToCall=eliminar_producto",
      data: { idproducto: $scope.producto.idproducto },
    }).then(function (response) {
      if (response.data.status === "1") {
        alert(response.data.message);
        $scope.iniciarSeccion();
        $("#modalProductoEliminar").modal("hide");
      } else {
        alert(response.data.message);
      }
    });
  };

  // Función para actualizar producto
  $scope.ActualizarProducto = function () {
    $http({
      method: "POST",
      url: "cod-productos.php?functionToCall=actualizar_producto",
      data: $scope.producto,
    }).then(
      function (response) {
        if (response.data.status === "1") {
          alert(response.data.message);
          //   $scope.BuscarProducto();
          $scope.iniciarSeccion();
          $("#modalProductoEditar").modal("hide");
        } else {
          alert(response.data.message);
        }
      },
      function (error) {
        console.error("Error:", error);
      }
    );
  };
});
