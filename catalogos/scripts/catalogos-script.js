var myApp = angular.module("appCatalogos", []);

myApp.controller("cCatalogos", function ($scope, $http) {
  $scope.listaPaises = [];
  $scope.listaEstados = [];
  $scope.listaCiudades = [];
  $scope.listaEntidades = [];
  $scope.listaBancos = [];

  $scope.detalles_entidad = {}; // Hacer que detalles_entidad sea global

  $scope.agregarContactoActivo = false;
  $scope.editando = false;

  // Inicializar entidad
  $scope.entidad = {
    identidad: 0,
    nombrecomercial: "",
    nombrecomun: "",
    direccion: "",
    idciudad: null,
    idestado: null,
    idpais: null,
    rfc: "",
    telefono: "",
    correo: "",
    web: "",
    credito: 0,
    saldo: 0,
    diascredito: 0,
    idbanco: null,
    cuenta: "",
    clabe: "",
    tipo: "",
  };

  // Obtener lista de bancos al cargar la página
  $http({
    method: "POST",
    url: "cod-entidades.php?functionToCall=obtener_bancos",
  }).then(function (response) {
    $scope.listaBancos = response.data;
  });

  // Obtener lista de países al cargar la página
  $http({
    method: "GET",
    url: "cod-entidades.php?functionToCall=obtener_paises",
  }).then(function (response) {
    $scope.listaPaises = response.data; // Asignar respuesta a listaPaises
  });

  // Función para manejar el cambio de país
  $scope.cambiarPais = function () {
    $scope.listaEstados = []; // Limpiar lista de estados
    $scope.listaCiudades = []; // Limpiar lista de ciudades
    if ($scope.detalles_entidad.idpais) {
      // Obtener estados del país seleccionado
      $http({
        method: "POST",
        url: "cod-entidades.php?functionToCall=obtener_estados",
        data: { idpais: $scope.detalles_entidad.idpais },
      }).then(function (response) {
        $scope.listaEstados = response.data; // Asignar respuesta a listaEstados
        // Si ya se tiene un estado seleccionado, mantenerlo
        if ($scope.detalles_entidad.idestado) {
          $scope.cambiarEstado();
        }
      });
    }
  };

  // Función para manejar el cambio de estado
  $scope.cambiarEstado = function () {
    $scope.listaCiudades = []; // Limpiar lista de ciudades
    if ($scope.detalles_entidad.idestado) {
      // Obtener ciudades del estado seleccionado
      $http({
        method: "POST",
        url: "cod-entidades.php?functionToCall=obtener_ciudades",
        data: { idestado: $scope.detalles_entidad.idestado },
      }).then(function (response) {
        $scope.listaCiudades = response.data; // Asignar respuesta a listaCiudades
      });
    }
  };

  var myData = { textoBuscar: "" };

  // Obtener lista de entidades al cargar la página
  $http({
    method: "POST",
    url: "cod-entidades.php?functionToCall=buscar_entidad",
    data: myData,
  }).then(function (response) {
    $scope.listaEntidades = response.data;
  });

  // Función para buscar entidad por texto
  $scope.BuscarEntidad = function () {
    var myData = { textoBuscar: String($("#txtTextoBuscar").val()) };
    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=buscar_entidad",
      data: myData,
    }).then(function (response) {
      $scope.listaEntidades = response.data;
    });
  };

  // Función para obtener información completa del entidad
  $scope.InfoEntidad = function (identidad) {
    console.log("Entidad id: ", identidad);
    return $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=info_entidad",
      data: { id_entidad: identidad },
    }).then(
      function (response) {
        console.log("Respuesta:", response.data);
        $scope.detalles_entidad = response.data;

        // Actualizar los estados y ciudades según el país y estado seleccionados
        $scope.cambiarPais();

        // Mostrar el modal con la información del entidad
        $("#modalEntidad").modal();
      },
      function (error) {
        console.error("Error:", error);
      }
    );
  };

  // Función para abrir el modal de edición de entidad
  $scope.AbrirEditar = function (item) {
    $scope
      .InfoEntidad(item.identidad)
      .then(function (response) {
        // Cargar listas para los combobox
        $scope.obtenerPaises();
        $scope.obtenerEstados(item.idpais);
        $scope.obtenerCiudades(item.idestado);
        $scope.obtenerBancos();

        // Abrir el modal
        $("#modalEntidad").modal();
      })
      .catch(function (error) {
        console.error("Error al obtener la información de la entidad:", error);
      });
  };
  // Función para abrir el modal de nuevo entidad
  $scope.AbrirNuevo = function () {
    $scope.entidad = {
      identidad: 0,
      nombrecomercial: "",
      nombrecomun: "",
      direccion: "",
      idciudad: null,
      idestado: null,
      idpais: null,
      rfc: "",
      telefono: "",
      correo: "",
      web: "",
      credito: 0,
      saldo: 0,
      diascredito: 0,
      idbanco: null,
      cuenta: "",
      clabe: "",
      tipo: "",
    };
    $("#modalEntidadNuevo").modal();
  };

  // Función para guardar entidad
  $scope.Grabar = function () {
    $scope.entidad.tipo = $scope.entidad.tipo || "Proveedor";

    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=grabar_entidad",
      data: $scope.entidad,
    }).then(
      function (response) {
        if (response.data.status === "1") {
          alert(response.data.message);
          $scope.BuscarEntidad();
          $("#modalEntidadNuevo").modal("hide");
        } else {
          alert(response.data.message);
        }
      },
      function (error) {
        console.error("Error:", error);
      }
    );
  };

  $scope.MostrarContactos = function (item) {
    $scope.id_entidad = item.identidad;

    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=contactos_entidad",
      data: { id_entidad: $scope.id_entidad },
    }).then(
      function (response) {
        $scope.contactos_entidad = Array.isArray(response.data)
          ? response.data
          : [];
        $scope.nuevoContacto = {}; // Inicializar el objeto para el nuevo contacto
        $scope.agregarContactoActivo = false; // Inicializar el estado del renglón editable
        $scope.editando = false; // Inicializar el estado de edición

        // Mostrar el modal con la información del entidad
        $("#modalContactosEntidad").modal();
      },
      function (error) {
        console.error("Error:", error);
      }
    );
  };

  $scope.AgregarContacto = function () {
    // Añadir el id del entidad al nuevo contacto
    $scope.nuevoContacto.id_entidad = $scope.id_entidad;

    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=agregar_contacto",
      data: $scope.nuevoContacto,
    }).then(
      function (response) {
        if (response.data.status == "1") {
          $scope.nuevoContacto = {};
          $scope.agregarContactoActivo = false; // Ocultar el renglón editable después de agregar el contacto
          // Recargar los contactos del entidad
          $scope.MostrarContactos({ identidad: $scope.id_entidad });
        } else {
          console.error("Error al agregar contacto:", response.data.message);
        }
      },
      function (error) {
        console.error("Error al agregar contacto:", error);
      }
    );
  };

  $scope.toggleAgregarContacto = function () {
    $scope.agregarContactoActivo = !$scope.agregarContactoActivo;
    $scope.editando = false; // Desactivar la edición si se está agregando un nuevo contacto
  };

  $scope.EditarContacto = function (contacto) {
    $scope.contactoOriginal = angular.copy(contacto);
    $scope.nuevoContacto = angular.copy(contacto);
    $scope.editando = true; // Activar el modo de edición
    $scope.agregarContactoActivo = false; // Desactivar agregar contacto si se está editando uno
  };

  $scope.cancelarEdicion = function () {
    $scope.editando = false;
    $scope.agregarContactoActivo = false;
    $scope.nuevoContacto = {};
  };

  $scope.GuardarEdicionContacto = function () {
    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=editar_contacto",
      data: {
        identidadcontactos: $scope.contactoOriginal.idcontacto,
        contacto: $scope.nuevoContacto.contacto,
        telefono: $scope.nuevoContacto.telefono,
        celular: $scope.nuevoContacto.celular,
        email: $scope.nuevoContacto.email,
        comentarios: $scope.nuevoContacto.comentarios,
      },
    }).then(
      function (response) {
        if (response.data.status == "1") {
          // Actualizar el contacto en la lista local
          $scope.MostrarContactos({ identidad: $scope.id_entidad });
          $scope.nuevoContacto = {};
          $scope.editando = false; // Ocultar el renglón editable después de editar el contacto
          $scope.agregarContactoActivo = false;
        } else {
          console.error("Error al editar contacto:", response.data.message);
        }
      },
      function (error) {
        console.error("Error al editar contacto:", error);
      }
    );
  };

  $scope.EliminarContacto = function (contacto) {
    $scope.id_contacto = contacto.idcontacto;

    if (confirm("¿Está seguro de que desea eliminar este contacto?")) {
      $http({
        method: "POST",
        url: "cod-entidades.php?functionToCall=eliminar_contacto",
        data: { idcontacto: $scope.id_contacto },
      }).then(
        function (response) {
          if (response.data.status == "1") {
            // Recargar los contactos del entidad
            $scope.MostrarContactos({ identidad: $scope.id_entidad });
          } else {
            console.error("Error al eliminar contacto:", response.data.message);
          }
        },
        function (error) {
          console.error("Error al eliminar contacto:", error);
        }
      );
    }
  };

  // Ocultar el renglón editable cuando se cierre el modal
  $("#modalContactosEntidad").on("hidden.bs.modal", function () {
    $scope.$apply(function () {
      $scope.agregarContactoActivo = false;
      $scope.editando = false;
    });
  });

  // Función para abrir el modal de eliminación de entidad
  $scope.AbrirEliminar = function (item) {
    $scope.entidad = item;
    $("#modalEntidadEliminar").modal();
  };

  // Función para actualizar entidad
  // Función para actualizar entidad
  $scope.Actualizar_Entidad = function (detalles_entidad) {
    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=grabar_entidad",
      data: detalles_entidad, // Asegúrate de que se envíen los datos correctos
    }).then(
      function (response) {
        if (response.data.status === "1") {
          alert(response.data.message);
          $scope.BuscarEntidad();
          $("#modalEntidad").modal("hide");
        } else {
          alert(response.data.message);
        }
      },
      function (error) {
        console.error("Error:", error);
      }
    );
  };

  // Función para eliminar entidad
  $scope.Eliminar = function () {
    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=eliminar_entidad",
      data: $scope.entidad,
    }).then(function (response) {
      if (response.data.status === "1") {
        alert(response.data.message);
        $scope.BuscarEntidad();
        $("#modalEntidadEliminar").modal("hide");
      } else {
        alert(response.data.message);
      }
    });
  };

  // Función para obtener lista de países
  $scope.obtenerPaises = function () {
    $http({
      method: "GET",
      url: "cod-entidades.php?functionToCall=obtener_paises",
    }).then(function (response) {
      $scope.listaPaises = response.data;
    });
  };

  // Función para obtener lista de estados
  $scope.obtenerEstados = function (idPais) {
    console.log("ID PAIS:", $scope.detalles_entidad);
    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=obtener_estados",
      data: { idpais: idPais },
    }).then(function (response) {
      $scope.listaEstados = response.data;
    });
  };

  // Función para obtener lista de ciudades
  $scope.obtenerCiudades = function (idEstado) {
    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=obtener_ciudades",
      data: { idestado: idEstado },
    }).then(function (response) {
      $scope.listaCiudades = response.data;
    });
  };

  // Función para obtener lista de bancos
  $scope.obtenerBancos = function () {
    $http({
      method: "POST",
      url: "cod-entidades.php?functionToCall=obtener_bancos",
    }).then(function (response) {
      $scope.listaBancos = response.data;
    });
  };
});
