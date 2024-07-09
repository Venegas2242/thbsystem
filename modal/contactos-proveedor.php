<div id="modalContactosProveedor" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl"> <!-- Agrega una clase para el ancho del modal -->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Contactos</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="col-nombre">Nombre</th>
                                <th class="col-telefono">Teléfono</th>
                                <th class="col-celular">Celular</th>
                                <th class="col-email">Email</th>
                                <th class="col-comentarios">Comentarios</th>
                                <th class="col-accion"></th> <!-- Columna para el botón de agregar contacto -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="contacto in contactos_proveedor">
                                <td>{{contacto.contacto}}</td>
                                <td>{{contacto.telefono}}</td>
                                <td>{{contacto.celular}}</td>
                                <td>{{contacto.email}}</td>
                                <td>{{contacto.comentarios}}</td>
                                <td></td> <!-- Columna vacía para alinear con el botón de agregar contacto -->
                            </tr>
                            <tr ng-if="contactos_proveedor.length === 0">
                                <td colspan="6" class="text-center">No hay contactos disponibles para este proveedor.</td>
                            </tr>
                            <tr ng-if="agregarContactoActivo">
                                <td><input type="text" class="form-control" ng-model="nuevoContacto.contacto" placeholder="Nombre" required></td>
                                <td><input type="text" class="form-control" ng-model="nuevoContacto.telefono" placeholder="Teléfono" required></td>
                                <td><input type="text" class="form-control" ng-model="nuevoContacto.celular" placeholder="Celular"></td>
                                <td><input type="email" class="form-control" ng-model="nuevoContacto.email" placeholder="Email" required></td>
                                <td><input type="text" class="form-control" ng-model="nuevoContacto.comentarios" placeholder="Comentarios"></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-xs" ng-click="AgregarContacto()">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary-modal btn-xs" ng-click="toggleAgregarContacto()">
                    <i class="fa" ng-class="agregarContactoActivo ? 'fa-minus' : 'fa-plus'"></i>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
