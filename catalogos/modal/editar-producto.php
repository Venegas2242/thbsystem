<!-- Modal para Editar Producto -->
<div id="modalProductoEditar" class="modal fade" role="dialog">
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
                        <label for="unidadProducto">Unidad:</label>
                        <select id="unidadProducto" ng-model="producto.idunidad" class="form-control" ng-options="unidad.idunidad as unidad.descripcion for unidad in listaUnidades">
                            <!-- <option value="" disabled>Seleccione una unidad</option> -->
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="grupoProducto">Grupo:</label>
                        <select id="grupoProducto" ng-model="producto.idgrupoproducto" class="form-control" ng-options="grupo.idgrupoproducto as grupo.descripcion for grupo in listaGrupos">
                            <!-- <option value="" disabled>Seleccione un grupo</option> -->
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="proveedorProducto">Proveedor:</label>
                        <select id="proveedorProducto" ng-model="producto.idproveedor" class="form-control" ng-options="proveedor.identidad as proveedor.nombre for proveedor in listaProveedores">
                            <!-- <option value="" disabled>Seleccione un proveedor</option> -->
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tipoProducto">Tipo:</label>
                        <select id="tipoProducto" ng-model="producto.idtipoproducto" class="form-control" ng-options="tipo.idtipoproducto as tipo.descripcion for tipo in listaTipos">
                            <!-- <option value="" disabled>Seleccione un tipo</option> -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-click="ActualizarProducto()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
