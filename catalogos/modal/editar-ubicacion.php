<div class="modal fade" id="editarUbicacionModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="editarModalLabel" ng-if="editar.tipo==0">Editar Pais</h5>
                <h5 class="modal-title" id="editarModalLabel" ng-if="editar.tipo==1">Editar Estado</h5>
                <h5 class="modal-title" id="editarModalLabel" ng-if="editar.tipo==2">Editar Ciudad</h5>
                <button type="button" class="close no-style-button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="actualizarUbicacion()">
                    <div class="form-group">
                        <label for="nombreEditar" ng-if="editar.tipo==0">Nombre del Pais:</label>
                        <label for="nombreEditar" ng-if="editar.tipo==1">Nombre del Estado:</label>
                        <label for="nombreEditar" ng-if="editar.tipo==2">Nombre del Ciudad:</label>
                        <input type="text" class="form-control" id="nombreEditar" ng-model="editar.nombre" required>
                    </div>
                    <button type="submit" class="btn btn-primary-custom">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>