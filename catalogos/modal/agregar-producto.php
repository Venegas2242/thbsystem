<div id="modalProductoNuevo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="codigoProducto">Código:</label>
                        <input type="text" id="codigoProducto" ng-model="producto.codigo" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="descripcionProducto">Descripción:</label>
                        <input type="text" id="descripcionProducto" ng-model="producto.descripcion" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ubicacionProducto">Ubicación:</label>
                        <input type="text" id="ubicacionProducto" ng-model="producto.ubicacion" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="costoProducto">Costo:</label>
                        <input type="number" id="costoProducto" ng-model="producto.costo" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="codigobarrasProducto">Código de Barras:</label>
                        <input type="text" id="codigobarrasProducto" ng-model="producto.codigobarras" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="idunidad">Unidad:</label>
                        <select id="idunidad" ng-model="producto.idunidad" class="form-control">
                            <option value="" disabled>Seleccione una unidad</option>
                            <option ng-repeat="unidad in listaUnidades" value="{{unidad.idunidad}}">{{unidad.descripcion}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idgrupoproducto">Grupo:</label>
                        <select id="idgrupoproducto" ng-model="producto.idgrupoproducto" class="form-control">
                            <option value="" disabled>Seleccione un grupo</option>
                            <option ng-repeat="grupo in listaGrupos" value="{{grupo.idgrupoproducto}}">{{grupo.descripcion}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="idproveedor">Proveedor:</label>
                        <select id="idproveedor" ng-model="producto.idproveedor" class="form-control">
                            <option value="" disabled>Seleccione un proveedor</option>
                            <option ng-repeat="proveedor in listaProveedores" value="{{proveedor.identidad}}">{{proveedor.nombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idtipoproducto">Tipo:</label>
                        <select id="idtipoproducto" ng-model="producto.idtipoproducto" class="form-control">
                            <option value="" disabled>Seleccione un tipo</option>
                            <option ng-repeat="tipo in listaTipos" value="{{tipo.idtipoproducto}}">{{tipo.descripcion}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-click="Grabar()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>