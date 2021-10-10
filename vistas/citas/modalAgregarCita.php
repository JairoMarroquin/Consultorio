<?php
include "../clases/Conexion.php";
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
        pacientes.id_estatus AS estatusPaciente,
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
        <script type="text/javascript">
            function mostrarDatosPsicologo(str){
                if (str==""){
                    document.getElementById("txtHint").innerHTML= "";
                    return;
                }
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange=function(){
                    if(this.readyState==4 && this.status==200){
                        document.getElementById("txtHint").innerHTML=this.responseText;
                    }
                }
                
                xmlhttp.open("GET", "../procesos/sesiones/obtenerDatosPsicologo.php?q="+str,true);
                xmlhttp.send();
            }
        </script>

        <script>
            $(document).ready(function(){
                $("#notas").keypress(function(){
                    if(this.value.length > 75){
                        return false;
                    }
                    $("#char_left").text("Caracteres restantes: "+(75 - this.value.length));
                });
            });    
            
        </script>

        <form method="POST" id="frmAgregarCita">
            <div class="modal fade" id="agregarCitas" tabindex="-1" role="dialog" aria-labelledby="agregarCitasLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarCitasLabel">Registrar cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <label for="paciente">Seleccionar paciente(*)</label>
                            <select class="form-control" name="paciente" id="paciente" onchange="mostrarDatosPsicologo(this.value)" required>
                                <option value="">Selecciona el paciente</option>
                                <?php
                                while($datosPaciente = mysqli_fetch_array($respuesta)){
                                    if($_SESSION['usuario']['rol'] == 1 && $datosPaciente['eliminado'] == 0 && $datosPaciente['estatusPaciente'] == 1){
                                ?>
                                <option value=" <?php echo $datosPaciente['idPaciente'];?> ">
                                    <?php echo $datosPaciente['nombrePaciente'];?> <?php echo $datosPaciente['segundoNombrePac'];?> <?php echo $datosPaciente['paternoPac']; ?> <?php echo $datosPaciente['maternoPac'];?>
                                </option>
                                <?php
                                }elseif($_SESSION['usuario']['id'] == $datosPaciente['idPsicPac'] && $datosPaciente['eliminado'] == 0 && $datosPaciente['estatusPaciente'] == 1){
                                ?>
                                    <option value=" <?php echo $datosPaciente['idPaciente'];?> ">
                                        <?php echo $datosPaciente['nombrePaciente'];?> <?php echo $datosPaciente['segundoNombrePac'];?> <?php echo $datosPaciente['paternoPac']; ?> <?php echo $datosPaciente['maternoPac'];?>
                                    </option>
                                <?php
                                }
                            }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5">
                            <label for="tipo_sesion">Seleccionar el tipo de sesión(*)</label>
                            <select class="form-control" name="tipo_sesion" id="tipo_sesion" required>
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
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4 text-center">
                            <hr>
                            <label>Psicólogo asignado</label>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4 text-center">
                            <span class="lead">
                                <span id="txtHint" class="badge badge-pill badge-primary"></span>
                            </span>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4">
                            <label for="dia">Día(*)</label>
                            <input type="date" class="form-control" id="dia" name="dia" placeholder="dia" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="hora_inicio">Hora(*)</label>
                            <input class="form-control" type="time" id="hora_cita" name="hora_cita" required>
                        </div>
                    </div>
                    <div class ="row">
                        <div class="col-sm-12">
                            <label for="notas">Notas</label>
                            <textarea maxlenght="75" name="notas" id="notas" class="form-control" rows = "4"></textarea>
                        </div> 
                        <div class="col-sm-5" id="char_left" style="color: #898989; font-size: 12px;">
                            
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