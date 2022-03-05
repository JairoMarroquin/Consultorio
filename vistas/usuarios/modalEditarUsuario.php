<form method="POST" id="frmEditarUsuario" onsubmit="return editarUsuario()">
    <div class="modal fade" id="modalEditarUsuarios" tabindex="-1" role="dialog" aria-labelledby="modalEditarUsuarios" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <input type="hidden" name="idUsuarioEditar" id="idUsuarioEditar" value="">
            <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
            <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4">
                    <label for="primer_nombreu">Primer Nombre</label>
                    <input type="text" class="form-control" id="primer_nombreu" name="primer_nombreu" placeholder="Nombre" required>
                </div>
                <div class="col-sm-4">
                    <label for="segundo_nombreu">Segundo Nombre</label>
                    <input type="text" class="form-control" id="segundo_nombreu" name="segundo_nombreu" placeholder="Segundo Nombre">
                </div>
                <div class="col-sm-4">
                    <label for="apellido_paternou">Apellido Paterno</label>
                    <input type="text" class="form-control" id="apellido_paternou" name="apellido_paternou" placeholder="Apellido Paterno" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="apellido_maternou">Apellido Materno</label>
                    <input type="text" class="form-control" id="apellido_maternou" name="apellido_maternou" placeholder="Apellido Materno">
                </div>
                <div class="col-sm-4">
                    <label for="usuariou">Usuario</label>
                    <input type="text" class="form-control" id="usuariou" name="usuariou" placeholder="Usuario">
                </div>
                <div class="col-sm-4">
                    <label for="contraseñau">Contraseña</label>
                    <input type="password" class="form-control" id="contraseñau" name="contraseñau" placeholder="Contraseña">
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-sm-4">
                    <hr>
                    <p>¿El usuario será psicólogo?</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="esPsicologou" id="radioSiu" value = "1">
                        <label class="form-check-label" for="radioSiu">Si</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="esPsicologou" id="radioNou" value = "0">
                        <label class="form-check-label" for="radioNou">No</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <hr>
                    <p>¿Que rol tendrá el usuario?</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rolCu" id="rolAdu" value = "2">
                        <label class="form-check-label" for="rolAdu">Administrador</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rolCu" id="rolCou" value = "3">
                        <label class="form-check-label" for="rolCou">Colaborador</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</span>
            <button class="btn btn-outline-primary">Guardar</button>
        </div>
        </div>
    </div>
    </div>
</form>