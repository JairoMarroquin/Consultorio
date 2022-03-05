<form method="POST" id="frmAgregarUsuario" onsubmit="return agregarUsuario()">
    <div class="modal fade" id="agregarUsuarios" tabindex="-1" role="dialog" aria-labelledby="agregarUsuariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
            <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4">
                    <label for="primer_nombre">Primer Nombre(*)</label>
                    <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" placeholder="Nombre" required>
                </div>
                <div class="col-sm-4">
                    <label for="segundo_nombre">Segundo Nombre</label>
                    <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" placeholder="Segundo Nombre">
                </div>
                <div class="col-sm-4">
                    <label for="apellido_paterno">Apellido Paterno(*)</label>
                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="apellido_materno">Apellido Materno</label>
                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno">
                </div>
                <div class="col-sm-4">
                    <label for="usuario">Usuario(*)</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
                </div>
                <div class="col-sm-4">
                    <label for="contraseña">Contraseña(*)</label>
                    <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-sm-4">
                    <hr>
                    <p>¿El usuario será psicólogo?</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="esPsicologo" id="radioSi" value = "1" checked>
                        <label class="form-check-label" for="radioSi">Si</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="esPsicologo" id="radioNo" value = "0">
                        <label class="form-check-label" for="radioNo">No</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <hr>
                    <p>¿Que rol tendrá el usuario?</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rol" id="rolA" value = "2" checked>
                        <label class="form-check-label" for="rolA">Administrador</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rol" id="rolC" value = "3">
                        <label class="form-check-label" for="rolC">Colaborador</label>
                    </div>
                </div>
            </div>
            <h7 style="color: red; font-size: 14px;">Los campos marcados con (*) son obligatorios.</h7>
        </div>
        <div class="modal-footer">
            <span class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</span>
            <button class="btn btn-outline-primary">Guardar</button>
        </div>
        </div>
    </div>
    </div>
</form>