<div id="modalEntidad" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>RFC:</label>
                        <input type="text" id="txtRFC" ng-model="detalles_entidad.rfc" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre Comercial:</label>
                        <input type="text" id="txtNombreFiscal" ng-model="detalles_entidad.nombrecomercial" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre referencia:</label>
                        <input type="text" id="txtNombreComun" ng-model="detalles_entidad.nombrecomun" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Direccion:</label>
                        <input type="text" id="txtDireccion" ng-model="detalles_entidad.direccion" class="form-control" />
                    </div>
                </div>
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4">
                        <label>País:</label>
                        <input type="text" id="txtPais" value="detalles_entidad.idpais" ng-model="detalles_entidad.nombrepais" class="form-control" disabled/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Estado:</label>
                        <input type="text" id="txtEstado" value="detalles_entidad.idestado" ng-value="detalles_entidad.nombreestado" class="form-control" disabled/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Ciudad:</label>
                        <input type="text" id="txtCiudad" value="detalles_entidad.idciudad" ng-value="detalles_entidad.nombreciudad" class="form-control" disabled/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Teléfono:</label>
                        <input type="text" id="txtTelefono" ng-model="detalles_entidad.telefono" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Correo:</label>
                        <input type="text" id="txtCorreo" ng-model="detalles_entidad.correo" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Página Web:</label>
                        <input type="text" id="txtWeb" ng-model="detalles_entidad.web" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Monto crédito:</label>
                        <input type="text" id="txtCredito" ng-model="detalles_entidad.credito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Días crédito:</label>
                        <input type="text" id="txtDiasCredito" ng-model="detalles_entidad.diascredito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Saldo:</label>
                        <input type="text" id="txtSaldo" ng-model="detalles_entidad.saldo" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Banco:</label>
                        <input type="text" id="txtBanco" value="detalles_entidad.idbanco" ng-value="detalles_entidad.nombrebanco" class="form-control" disabled/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Cuenta:</label>
                        <input type="text" id="txtCuenta" ng-model="detalles_entidad.cuenta" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>CLABE:</label>
                        <input type="text" id="txtClabe" ng-model="detalles_entidad.clabe" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-click="Actualizar_Entidad(detalles_entidad)" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>