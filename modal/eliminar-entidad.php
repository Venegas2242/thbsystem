<div id="modalEntidadEliminar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title" style="color:red;">¿Desea eliminar el registro?</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-16">
                        <label>RFC:</label>
                        <input type="text" ng-model="entidad.rfc" readonly="true" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-16">
                        <label>Nombre comercial:</label>
                        <input type="text" ng-model="entidad.nombrecomercial" readonly="true" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-click="Eliminar()" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>