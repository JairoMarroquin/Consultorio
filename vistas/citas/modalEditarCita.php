<?php
    $con = new Conexion();
    $conexion = $con->conectar();
    $sql="SELECT 
            pacientes.id_paciente AS idPaciente,
            pacientes.id_psicologo AS idPsicPac,
            pacientes.eliminado,
            pacientes.primer_nombre AS nombrePaciente,
            pacientes.segundo_nombre AS segundoNombrePac,
            pacientes.apellido_paterno AS paternoPac,
            pacientes.apellido_materno AS maternoPac,
            usuarios.id_usuario as idPsic, 
            usuarios.bit_psicologo as esPsic,
            usuarios.primer_nombre as nombrePsic, 
            usuarios.segundo_nombre as segundoNombrePsic,
            usuarios.apellido_paterno as paternoPsic, 
            usuarios.apellido_materno as maternoPsic, 
            usuarios.bit_activo as psicActivo
            FROM
            pacientes AS pacientes
                INNER JOIN
            usuarios AS usuarios ON pacientes.id_psicologo = usuarios.id_usuario
            ORDER BY pacientes.primer_nombre, pacientes.segundo_nombre, pacientes.apellido_paterno, pacientes.apellido_materno";

    $sql2="select id_tipoSesion as idTipoSesion, nombre, costo, eliminada from tipo_sesion";

    $respuesta = mysqli_query($conexion, $sql);
    $respuesta2 = mysqli_query($conexion, $sql2);
?>

<html>
    <body>
        <script>
            $(document).ready(function(){
                $("#notasu").keypress(function(){
                    if(this.value.length > 75){
                        return false;
                    }
                    $("#char_leftu").text("Caracteres restantes: "+(75 - this.value.length));
                });
            });    
            
        </script>

        <form method="POST" id="frmEditarCita">
            <div class="modal fade" id="editarCitas" tabindex="-1" role="dialog" aria-labelledby="editarCitasLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" name="idCitaEditar" id="idCitaEditar" value="">
                    <h5 class="modal-title" id="editarCitasLabel">Editar cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <label for="pacienteu">Seleccionar paciente(*)</label>
                            <select class="form-control" name="pacienteu" id="pacienteu" required>
                                <option value="">Selecciona el paciente</option>
                                <?php
                                    while($datosPaciente = mysqli_fetch_array($respuesta)){
                                        if($_SESSION['usuario']['rol'] == 1 &&  $datosPaciente['eliminado'] == 0 && $datosPaciente['estatusPaciente'] == 1){
                                ?>
                                <option value="<?php echo $datosPaciente['idPaciente'];?>">
                                    <?php echo $datosPaciente['nombrePaciente'];?> <?php echo $datosPaciente['segundoNombrePac'];?> <?php echo $datosPaciente['paternoPac']; ?> <?php echo $datosPaciente['maternoPac'];?>
                                </option>
                                <?php
                                    }elseif($_SESSION['usuario']['id'] == $datosPaciente['idPsicPac'] &&  $datosPaciente['eliminado'] == 0 && $datosPaciente['estatusPaciente'] == 1){

                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5">
                            <label for="tipo_sesionu">Seleccionar el tipo de sesión(*)</label>
                            <select class="form-control" name="tipo_sesionu" id="tipo_sesionu" required>
                                <option value="">Seleccionar el tipo de sesión</option>
                                <?php
                                    while($tipoSesion = mysqli_fetch_array($respuesta2)){
                                        if($tipoSesion['eliminado'] == 0){
                                ?>
                                <option value="<?php echo $tipoSesion['idTipoSesion'];?>">
                                    <?php echo $tipoSesion['nombre'];?> $<?php echo $tipoSesion['costo'];?>
                                </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4">
                            <label for="diau">Día(*)</label>
                            <input type="date" class="form-control" id="diau" name="diau" placeholder="dia" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="hora_citau">Hora(*)</label>
                            <input class="form-control" type="time" id="hora_citau" name="hora_citau" required>
                        </div>
                    </div>
                    <div class ="row">
                        <div class="col-sm-12">
                            <label for="notasu">Notas</label>
                            <textarea maxlenght="75" name="notasu" id="notasu" class="form-control" rows = "4"></textarea>
                        </div> 
                        <div class="col-sm-5" id="char_leftu" style="color: #898989; font-size: 12px;">
                            
                        </div> 
                    </div>
                    <br>
                <h7 style="color: #FF0B0B; font-size: 14px;">Los campos marcados con (*) son obligatorios.</h7>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-outline-secondary" data-dismiss="modal">Close</span>
                    <button class="btn btn-outline-primary">Guardar</button>
                </div>
                </div>
            </div>
            </div>
        </form>
    </body>
</html>