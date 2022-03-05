<?php
    $con = new Conexion();
    $conexion = $con->conectar();
    $sql="SELECT 
            pacientes.id_paciente,
            pacientes.id_psicologo,
            pacientes.primer_nombre as nombrePaciente,
            pacientes.segundo_nombre as segundoNombrePaciente,
            pacientes.apellido_paterno as apellidoPaciente,
            pacientes.apellido_materno as apellidoMaternoPaciente,
            pacientes.eliminado, 
            usuarios.id_usuario, 
            usuarios.primer_nombre as nombrePsicologo, 
            usuarios.segundo_nombre as segundoNombrePsicologo,
            usuarios.apellido_paterno as apellidoPsicologo, 
            usuarios.apellido_materno as apellidoMaternoPsicologo
        FROM
            pacientes AS pacientes
                INNER JOIN
            usuarios AS usuarios ON pacientes.id_psicologo = usuarios.id_usuario";

    $respuesta = mysqli_query($conexion, $sql);
    
?>                   
<form id="frmEditarSesion" method="POST">
    <div class="modal fade" id="modalEditarSesiones" tabindex="-1" role="dialog" aria-labelledby="modalEditarSesiones" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <input type="hidden" name="idSesionEditar" id="idSesionEditar" value="">
                <input type="hidden" name="idPaciente" id="idPaciente" value="">
                    <h5 class="modal-title" id="exampleModalLabel">Editar sesión</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="row">
                                <label for="citau">¿La sesión tuvo cita previa?</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="citau" id="citauSi" value = "1" checked>
                                <label class="form-check-label" for="citauSi">
                                    Si
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="citau" id="citauNo" value="2">
                                <label class="form-check-label" for="citauNo">
                                    No
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="row">
                                <label for="tipo_sesionu">Tipo de Sesión</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_sesionu" id="indu" value = "1" checked>
                                <label class="form-check-label" for="indu">
                                    Individual
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_sesionu" id="parejau" value="2">
                                <label class="form-check-label" for="parejau">
                                    En Pareja
                                </label>
                            </div>
                        </div>
                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="diau">Día(*)</label>
                            <input type="date" class="form-control" id="diau" name="diau" placeholder="diau" required>
                        </div>
                        <div class="col-sm-3">
                            <label for="hora_iniciou">Hora Inicio(*)</label>
                            <input class="form-control" type="time" id="hora_iniciou" name="hora_iniciou" required>
                        </div>
                        <div class="col-sm-3">
                            <label for="hora_finu">Hora Fin(*)</label>
                            <input class="form-control" type="time" id="hora_finu" name="hora_finu" required>
                        </div>
                        <div class="col-sm-4">

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <span class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</span> <!--se pone span por el onSubmit, si se da clic en cerrar tambien se guardaria el paciente-->
                    <button class="btn btn-outline-primary">Guardar Datos</button>
                </div>

            </div>
        </div>
    </div>
</form> 