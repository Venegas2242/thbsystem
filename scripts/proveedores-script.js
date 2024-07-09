var myApp = angular.module('appCatalogos', []);

myApp.controller('cProveedores', function ($scope, $http) {
    $scope.listaPaises = [];
    $scope.listaEstados = [];
    $scope.listaCiudades = [];
    $scope.listaProveedores = [];

    // Inicializar proveedor
    $scope.proveedor = {
        idproveedor: 0,
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
        idbanco: "",
        cuenta: "",
        clabe: ""
    };

    // Obtener lista de países al cargar la página
    $http({
        method: "GET",
        url: 'cod-proveedores.php?functionToCall=obtener_paises'
    }).then(function (response) {
        $scope.listaPaises = response.data; // Asignar respuesta a listaPaises
    });

    // Función para manejar el cambio de país
    $scope.cambiarPais = function() {
        $scope.listaEstados = []; // Limpiar lista de estados
        $scope.listaCiudades = []; // Limpiar lista de ciudades
        if ($scope.proveedor.idpais) {
            // Obtener estados del país seleccionado
            $http({
                method: "POST",
                url: 'cod-proveedores.php?functionToCall=obtener_estados',
                data: { idpais: $scope.proveedor.idpais }
            }).then(function (response) {
                $scope.listaEstados = response.data; // Asignar respuesta a listaEstados
                // Si ya se tiene un estado seleccionado, mantenerlo
                if ($scope.proveedor.idestado) {
                    $scope.cambiarEstado();
                }
            });
        }
    };

    // Función para manejar el cambio de estado
    $scope.cambiarEstado = function() {
        $scope.listaCiudades = []; // Limpiar lista de ciudades
        if ($scope.proveedor.idestado) {
            // Obtener ciudades del estado seleccionado
            $http({
                method: "POST",
                url: 'cod-proveedores.php?functionToCall=obtener_ciudades',
                data: { idestado: $scope.proveedor.idestado }
            }).then(function (response) {
                $scope.listaCiudades = response.data; // Asignar respuesta a listaCiudades
            });
        }
    };

    var myData = { textoBuscar: '' };

    // Obtener lista de proveedores al cargar la página
    $http({
        method: "POST",
        url: 'cod-proveedores.php?functionToCall=buscar_proveedor',
        data: myData
    }).then(function (response) {
        $scope.listaProveedores = response.data;
    });

    // Función para buscar proveedor por texto
    $scope.BuscarProveedor = function () {
        var myData = { textoBuscar: String($("#txtTextoBuscar").val()) };
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=buscar_proveedor',
            data: myData
        }).then(function (response) {
            $scope.listaProveedores = response.data;
        });
    };

    // Función para obtener información completa del proveedor
    $scope.InfoProveedor = function (idproveedor) {
        //console.log('Id proveedor:', idproveedor);
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=info_proveedor',
            data: { id_proveedor: idproveedor }
        }).then(function (response) {
            console.log('Información completa del proveedor:', response.data[0]); // Imprimir la información completa en la consola
            $scope.detalles_proveedor = response.data[0];

            // Actualizar los estados y ciudades según el país y estado seleccionados
            // $scope.cambiarPais();

            // Mostrar el modal con la información del proveedor
            $("#modalProveedor").modal();
        }, function (error) {
            console.error('Error:', error);
        });
    };

    // Función para abrir el modal de edición de proveedor
    $scope.AbrirEditar = function (item) {
        console.log('Info card:', item); // Imprimir el objeto completo en la consola
        $scope.InfoProveedor(item.idproveedor);
    };

    // Función para abrir el modal de nuevo proveedor
    $scope.AbrirNuevo = function () {
        $scope.proveedor = {
            idproveedor: 0,
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
            idbanco: "",
            cuenta: "",
            clabe: ""
        };
        $("#modalProveedorNuevo").modal();
    };

    // Función para guardar proveedor
    $scope.Grabar = function () {
        console.log('Datos del proveedor:', $scope.proveedor);

        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=grabar_proveedor',
            data: $scope.proveedor
        }).then(function (response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $scope.BuscarProveedor();
                $("#modalProveedorNuevo").modal("hide");
                
            } else {
                alert(response.data.message);
            }
        }, function (error) {
            console.error('Error:', error);
        });
    };

    $scope.MostrarContactos = function (item) {
        $scope.id_proveedor = item.idproveedor;
        console.log("Id del proveedor: ", $scope.id_proveedor);
    
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=contactos_proveedor',
            data: {id_proveedor: $scope.id_proveedor}
        }).then(function (response) {
            $scope.contactos_proveedor = Array.isArray(response.data) ? response.data : [];
            console.log('Contactos del proveedor:', $scope.contactos_proveedor);
            $scope.nuevoContacto = {}; // Inicializar el objeto para el nuevo contacto
            $scope.agregarContactoActivo = false; // Inicializar el estado del renglón editable
    
            // Mostrar el modal con la información del proveedor
            $("#modalContactosProveedor").modal();
        }, function (error) {
            console.error('Error:', error);
        });
    };
    
    $scope.AgregarContacto = function () {
        // Añadir el id del proveedor al nuevo contacto
        $scope.nuevoContacto.id_proveedor = $scope.id_proveedor;
    
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=agregar_contacto',
            data: $scope.nuevoContacto
        }).then(function (response) {
            console.log('Contacto agregado:', response.data);
            if(response.data.status == "1") {
                /*
                $scope.contactos_proveedor.push({
                    idproveedorcontactos: response.data.idproveedorcontactos, // Asegúrate de devolver el idproveedorcontactos en la respuesta del servidor
                    contacto: $scope.nuevoContacto.contacto,
                    telefono: $scope.nuevoContacto.telefono,
                    celular: $scope.nuevoContacto.celular,
                    email: $scope.nuevoContacto.email,
                    comentarios: $scope.nuevoContacto.comentarios
                });
                */
                // Limpiar el formulario después de agregar el contacto
                $scope.nuevoContacto = {};
                $scope.agregarContactoActivo = false; // Ocultar el renglón editable después de agregar el contacto
                // Recargar los contactos del proveedor
                $scope.MostrarContactos({ idproveedor: $scope.id_proveedor});
            } else {
                console.error('Error al agregar contacto:', response.data.message);
            }
        }, function (error) {
            console.error('Error al agregar contacto:', error);
        });
    };
    
    $scope.toggleAgregarContacto = function () {
        $scope.agregarContactoActivo = !$scope.agregarContactoActivo;
    };
    
    $scope.EditarContacto = function (contacto) {
        // Guardar el contacto original para usarlo en la edición
        $scope.contactoOriginal = angular.copy(contacto);
        $scope.nuevoContacto = angular.copy(contacto);
        $scope.agregarContactoActivo = true;
    };
    
    $scope.GuardarEdicionContacto = function () {
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=editar_contacto',
            data: {
                id_proveedor: $scope.id_proveedor,
                idproveedorcontactos: $scope.contactoOriginal.idproveedorcontactos,
                contacto: $scope.nuevoContacto.contacto,
                telefono: $scope.nuevoContacto.telefono,
                celular: $scope.nuevoContacto.celular,
                email: $scope.nuevoContacto.email,
                comentarios: $scope.nuevoContacto.comentarios
            }
        }).then(function (response) {
            console.log('Contacto editado:', response.data);
            if(response.data.status == "1") {
                // Actualizar el contacto en la lista local
                var index = $scope.contactos_proveedor.findIndex(c => c.idproveedorcontactos === $scope.contactoOriginal.idproveedorcontactos);
                if (index > -1) {
                    $scope.contactos_proveedor[index] = angular.copy($scope.nuevoContacto);
                }
                $scope.nuevoContacto = {};
                $scope.agregarContactoActivo = false; // Ocultar el renglón editable después de editar el contacto
            } else {
                console.error('Error al editar contacto:', response.data.message);
            }
        }, function (error) {
            console.error('Error al editar contacto:', error);
        });
    };
    
    $scope.EliminarContacto = function (contacto) {
        $scope.id_contacto = contacto.idcontacto;
        console.log("Info contacto:", $scope.id_contacto)
        
        if(confirm('¿Está seguro de que desea eliminar este contacto?')) {
            $http({
                method: "POST",
                url: 'cod-proveedores.php?functionToCall=eliminar_contacto',
                data: {idcontacto: $scope.id_contacto}
            }).then(function (response) {
                console.log("Esto esta regresando response.data: ", response.data)
                if(response.data.status == "1") {
                    // Eliminar el contacto de la lista local
                    /*const index = $scope.contactos_proveedor.indexOf(contacto);
                    if (index > -1) {
                        $scope.contactos_proveedor.splice(index, 1);
                    }*/
                   // Recargar los contactos del proveedor
                    $scope.MostrarContactos({ idproveedor: $scope.id_proveedor });
                } else {
                    console.error('Error al eliminar contacto:', response.data.message);
                }
            }, function (error) {
                console.error('Error al eliminar contacto:', error);
            });
        }
    };
    
    // Ocultar el renglón editable cuando se cierre el modal
    $('#modalContactosProveedor').on('hidden.bs.modal', function () {
        $scope.$apply(function () {
            $scope.agregarContactoActivo = false;
        });
    });
    
    
    



    // Función para abrir el modal de eliminación de proveedor
    $scope.AbrirEliminar = function (item) {
        $scope.proveedor = item;
        $("#modalProveedorEliminar").modal();
    };

    // Función para actualizar proveedor
    $scope.Actualizar_Proveedor = function (detalles_proveedor) {
        console.log("Datos del proveedor a actualizar: ", detalles_proveedor); // Imprimir en consola
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=grabar_proveedor',
            data: $scope.detalles_proveedor
        }).then(function (response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $scope.BuscarProveedor();
                $("#modalProveedor").modal("hide");
            } else {
                alert(response.data.message);
            }
        }, function (error) {
            console.error('Error:', error);
        });
    };
    
    // Función para eliminar proveedor
    $scope.Eliminar = function () {
        $http({
            method: "POST",
            url: 'cod-proveedores.php?functionToCall=eliminar_proveedor',
            data: $scope.proveedor
        }).then(function (response) {
            if (response.data.status === "1") {
                alert(response.data.message);
                $scope.BuscarProveedor();
                $("#modalProveedorEliminar").modal("hide");
            } else {
                alert(response.data.message);
            }
        });
    };
});
