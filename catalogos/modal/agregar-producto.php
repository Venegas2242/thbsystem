<div id="modalProductoNuevo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="codigo">Código:</label>
                        <input type="text" id="codigo" ng-model="producto.codigo" class="form-control" />
                    </div>
                    <div class="form-group col-md-8">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" ng-model="producto.descripcion" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="ubicacion">Ubicación:</label>
                        <input type="text" id="ubicacion" ng-model="producto.ubicacion" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="costo">Costo:</label>
                        <input type="number" id="costo" ng-model="producto.costo" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="codigobarras">Código de Barras:</label>
                        <input type="text" id="codigobarras" ng-model="producto.codigobarras" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idunidad">Unidad:</label>
                        <select id="idunidad" ng-model="producto.idunidad" class="form-control">
                            <option value="">Seleccione una unidad</option>
                            <option ng-repeat="unidad in listaUnidades" value="{{unidad.idunidad}}">{{unidad.descripcion}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="idgrupoproducto">Grupo:</label>
                        <select id="idgrupoproducto" ng-model="producto.idgrupoproducto" class="form-control">
                            <option value="">Seleccione un grupo</option>
                            <option ng-repeat="grupo in listaGrupos" value="{{grupo.idgrupoproducto}}">{{grupo.descripcion}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="activo">Activo:</label>
                        <input type="checkbox" id="activo" ng-model="producto.activo" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inventariado">Inventariado:</label>
                        <input type="checkbox" id="inventariado" ng-model="producto.inventariado" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-click="GrabarProducto()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>