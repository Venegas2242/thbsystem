var appRequisicion = angular.module("appRequisicion", []);

appRequisicion.controller("cRequisicion", function ($scope, $http) {
    $scope.listaUnidades = [];
    $scope.sugerencias = [];
    $scope.textoBuscar = "";
    $scope.requisicion = {};
    $scope.articulosSeleccionados = [];
    $scope.articuloValido = false;
    $recargar = false;

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
        $scope.articuloValido = false; // Invalidate previous selection when typing starts
        $scope.requisicion.articulo = null; // Reset selected article ID

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
                // Check if the current input matches any valid suggestion and set the valid flag
                $scope.articuloValido = $scope.sugerencias.some(
                    (s) => s.descripcion === $scope.textoBuscar && s.idproducto
                );
            });
        } else {
            $scope.sugerencias = [];
        }
    };

    $scope.SeleccionarProducto = function (producto) {
        $scope.textoBuscar = producto.descripcion; // Muestra la descripción del producto en el campo de texto
        $scope.requisicion.articulo = producto.idproducto; // Guarda el id del producto seleccionado
        $scope.sugerencias = []; // Limpia las sugerencias
        $scope.articuloValido = true; // Indica que se ha seleccionado un artículo válido
    };

    $scope.AgregarDatos = function (form) {
        console.log("Formulario: ", form);

        // Verifica si el artículo es válido, tiene un idproducto y si el formulario es válido
        if (
            
            !$scope.articuloValido ||
            !$scope.requisicion.articulo
        ) {
            $scope.MostrarNotificacion(
                "Error",
                "Selecciona un artículo válido de la lista.",
                false
            );
        } else if (parseFloat(form.cantidad.$viewValue) <= 0) {
            $scope.MostrarNotificacion(
                "Error",
                "La cantidad debe ser mayor a cero.",
                false
            );
        } else {
            var unidadSeleccionada =
                document.getElementById("unidad").options[
                    document.getElementById("unidad").selectedIndex
                ].text;
            var idunidadSeleccionada = parseInt(
                document.getElementById("unidad").options[
                    document.getElementById("unidad").selectedIndex
                ].value,
                10
            );

            // Convertir la fecha al formato 'YYYY-MM-DD'
            // var fechaCumplir = new Date(
            //     $scope.requisicion.fecha.split("/").reverse().join("-")
            // )
            //     .toISOString()
            //     .split("T")[0];

            $scope.articulosSeleccionados.push({
                idproducto: $scope.requisicion.articulo, // Asegúrate de que el idproducto esté aquí
                producto: $scope.textoBuscar,
                idunidad: idunidadSeleccionada,
                unidad: unidadSeleccionada,
                cantidad: $scope.requisicion.cantidad,
            });

            // Reiniciar los campos después de agregar
            $scope.requisicion = {};
            $scope.textoBuscar = "";
            $scope.articuloValido = false;
        }
    };

    $scope.QuitarArticulo = function (index) {
        $scope.articulosSeleccionados.splice(index, 1);
    };

    $scope.EnviarSolicitud = function (idusuario) {
        console.log("ID de usuario: ", idusuario);

        // if ($scope.articulosSeleccionados.length === 0) {
        //     // Mostrar notificación si no hay artículos en la tabla
        //     $scope.MostrarNotificacion(
        //         "Error",
        //         "Debes agregar al menos un artículo a la requisición antes de enviar.",
        //         false
        //     );
        //     return; // Salir de la función para evitar el envío
        // }

        // var requisicion = {
        //     idusuario: idusuario, // Utiliza el ID de usuario cargado desde una fuente válida.
        //     numerorequisicion: "REQ" + new Date().getTime(),
        //     fechacaptura: new Date().toISOString().split("T")[0],
        //     estado: 1,
        //     observaciones: document.getElementById("comentarios").value,
        //     fecha_cumplir: document.getElementById("fecha").value,
        //     detalles: $scope.articulosSeleccionados.map(function (articulo) {
        //         return {
        //             idproducto: articulo.idproducto, // Aquí se envía el idproducto
        //             cantidad: articulo.cantidad,
        //             idunidad: articulo.idunidad,
        //         };
        //     }),
        // };

        // console.log("Requisición a enviar: ", requisicion);

        // $http({
        //     method: "POST",
        //     url: "cod-requisicion.php?functionToCall=alta_requisicion",
        //     data: requisicion,
        // }).then(
        //     function (response) {
        //         console.log("Respuesta del servidor: ", response);
        //         //     $scope.MostrarNotificacion("response.data.message");
        //         // Recargar la página después de enviar con éxito
        //         $scope.MostrarNotificacion(
        //             "Solicitud enviada",
        //             "Número de requisición: " + requisicion.numerorequisicion,
        //             true
        //         );
        //     },
        //     function (error) {
        //         console.error("Error al enviar la solicitud: ", error);
        //         $scope.MostrarNotificacion(
        //             "Ocurrió un error al enviar la solicitud.",
        //             false
        //         );
        //     }
        // );
    };

    $scope.MostrarNotificacion = function (encabezado, mensaje, b_recargar) {
        $("#modalNotificacion .modal-title").text(encabezado);
        $("#modalNotificacion .modal-body").text(mensaje);
        $("#modalNotificacion").modal("show");
        $recargar = b_recargar;
    };

    $scope.CerrarNotificacion = function () {
        $("#modalNotificacion").modal("hide");
        if ($recargar) window.location.reload();
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
