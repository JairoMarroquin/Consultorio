<form method="POST" id="frmEditarCuenta">
    <div class="modal fade" id="modalEditarCuenta" tabindex="-1" role="dialog" aria-labelledby="modalEditarCuentaTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" name="idCuentaEditar" id="idCuentaEditar" value="<?php echo $_SESSION['usuario']['id'];?>">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar cuenta</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="primer_nombreEd">Primer Nombre(*)</label>
                        <input type="text" class="form-control" id="primer_nombreEd" name="primer_nombreEd" placeholder="Nombre" required>
                    </div>
                    <div class="col-sm-4">
                        <label for="segundo_nombreEd">Segundo Nombre</label>
                        <input type="text" class="form-control" id="segundo_nombreEd" name="segundo_nombreEd" placeholder="Nombre">
                    </div>
                    <div class="col-sm-4">
                        <label for="apellido_paternoEd">Apellido Paterno(*)</label>
                        <input type="text" class="form-control" id="apellido_paternoEd" name="apellido_paternoEd" placeholder="Apellido Paterno" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="apellido_maternoEd">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellido_maternoEd" name="apellido_maternoEd" placeholder="Apellido Materno">
                    </div>
                    <div class="col-sm-4">
                        <label for="usuarioEd">Usuario(*)</label>
                        <input type="text" class="form-control" id="usuarioEd" name="usuarioEd" placeholder="Usuario">
                    </div>
                    <div class="col-sm-4">
                        <label for="contraseñaEd">Contraseña(*)</label>
                        <input type="password" class="form-control" id="contraseñaEd" name="contraseñaEd" placeholder="Contraseña">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</span>
                <button class="btn btn-outline-primary" onClick="confirmAccEdit()">Guardar cambios</button>
            </div>
            </div>
        </div>
    </div>
</form>