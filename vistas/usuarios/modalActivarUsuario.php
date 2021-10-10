<form id="frmActivarUsuario" method="POST">
    <div class="modal fade" id="modalActivarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalActivarUsuario" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <input type="hidden" name="idUsuarioActivar" id="idUsuarioActivar" value="">
            <h5 class="modal-title" id="exampleModalLongTitle">Activar Usuario</h5>
            <span type="button" class="close" data-dismiss="modal" aria-label="Close"></span>
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="activarUsuario" name="activarUsuario" value="desactivarSi" required>
                <label class="form-check-label" for="activarUsuario">Activar Usuario.</label>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-outline-danger" data-dismiss="modal">Cerrar</span>
            <button class="btn btn-outline-primary">Guardar Cambios</button>
        </div>
        </div>
    </div>
    </div>
</form>