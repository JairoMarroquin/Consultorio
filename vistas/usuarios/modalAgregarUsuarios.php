<form method="POST" id="frmAgregarUsuario" onsubmit="return agregarUsuario()">
    <div class="modal fade" id="agregarUsuarios" tabindex="-1" role="dialog" aria-labelledby="agregarUsuariosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="input-field col-sm-4">
                        <input id="primer_nombre" name="primer_nombre" type="text" class="validate" required>
                        <label for="primer_nombre">Primer Nombre(*)</label>
                    </div>
                    <div class="input-field col-sm-4">
                        <input id="segundo_nombre" name="segundo_nombre" type="text" class="validate">
                        <label for="segundo_nombre">Segundo Nombre</label>
                    </div>
                    <div class="input-field col-sm-4">
                        <input id="apellido_paterno" name="apellido_paterno" type="text" class="validate" required>
                        <label for="apellido_paterno">Apellido Paterno(*)</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col-sm-4">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input id="apellido_materno" name="apellido_materno" type="text" class="validate">
                    </div>
                    <div class="input-field col-sm-4">
                        <label for="usuario">Usuario(*)</label>
                        <input id="usuario" name="usuario" type="text" class="validate" required>
                    </div>
                    <div class="input-field col-sm-4">
                        <label for="contraseña">Contraseña(*)</label>
                        <input id="contraseña" name="contraseña" type="password" class="validate" required>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-sm-4">
                        <hr>
                        <p>¿El usuario será psicólogo?</p>
                        <!--<label>
                            <input class="" type="radio" name="esPsicologo" id="radioSi" value = "1" checked>
                            <span >Si</span>
                        </label>
                        <label>
                            <input class="" type="radio" name="esPsicologo" id="radioNo" value = "0">
                            <span>No</span>
                        </label>-->

                        <div class="switch">
                            <label>
                            No
                            <input type="hidden" name="esPsicologo" value='0'>
                            <input type="checkbox" name="esPsicologo" id="esPsicologo" value = '1' checked>
                            <span class="lever"></span>
                            Sí
                            </label>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <hr>
                        <p>¿Qué rol tendrá el usuario?</p>
                        <label>
                            <input class="with-gap" type="radio" name="rol" id="rolA" value = "2" checked>
                            <span>Administrador</span>
                        </label>
                        <label>
                            <input class="with-gap" type="radio" name="rol" id="rolC" value = "3">
                            <span>Colaborador</span>
                        </label>
                    </div>
                </div><br><br><br>
                <span style="color: red; font-size: 14px;">Los campos marcados con (*) son obligatorios.</span>
            </div>
            <div class="modal-footer">
                <span class="btn" data-bs-dismiss="modal">Cerrar</span>
                <button class="btn">Guardar</button>
            </div>
        </div>
    </div>
</form>