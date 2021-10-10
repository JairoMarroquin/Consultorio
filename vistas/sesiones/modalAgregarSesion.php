<?php
    include "../clases/Conexion.php";
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
            pacientes.id_estatus AS estatusPaciente, 
            usuarios.id_usuario, 
            usuarios.primer_nombre as nombrePsicologo, 
            usuarios.segundo_nombre as segundoNombrePsicologo,
            usuarios.apellido_paterno as apellidoPsicologo, 
            usuarios.apellido_materno as apellidoMaternoPsicologo
        FROM
            pacientes AS pacientes
                INNER JOIN
            usuarios AS usuarios ON pacientes.id_psicologo = usuarios.id_usuario
            ORDER BY pacientes.primer_nombre, pacientes.segundo_nombre, pacientes.apellido_paterno, pacientes.apellido_materno";

    

    $respuesta = mysqli_query($conexion, $sql);
    
?>

<html>
<head>
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

</head>
    <body>                     
        <form id="frmAgregarSesion" method="POST">
            <div class="modal fade" id="modalAgregarSesiones" tabindex="-1" role="dialog" aria-labelledby="modalAgregarSesiones" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar Sesión</h5>
                            <span type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </span>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label for="paciente">Seleccionar paciente(*)</label>
                                    <select class="form-control" name="paciente" id="paciente" onchange="mostrarDatosPsicologo(this.value)" required>
                                        <option value="">Selecciona el paciente</option>
                                        <?php
                                            while($datosPaciente = mysqli_fetch_array($respuesta)){
                                                if($datosPaciente['eliminado'] == 0 && $datosPaciente['estatusPaciente'] == 1){
                                        ?>
                                            <option value=" <?php echo $datosPaciente['id_paciente']; ?> "> 
                                                <?php echo $datosPaciente['nombrePaciente'];?> <?php echo $datosPaciente['segundoNombrePaciente'];?> <?php echo $datosPaciente['apellidoPaciente']; ?> <?php echo $datosPaciente['apellidoMaternoPaciente'];?>
                                            </option>
                                        <?php   
                                            }                                  
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row justfy-content-center">
                                        <label for="cita">¿La sesión tuvo cita previa?</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="cita" id="citaSi" value = "1" checked>
                                        <label class="custom-control-label" for="citaSi">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="cita" id="citaNo" value="2">
                                        <label class="custom-control-label" for="citaNo">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <label for="tipo_sesion">Tipo de Sesión</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="tipo_sesion" id="ind" value = "1" checked>
                                        <label class="custom-control-label" for="ind">
                                            Individual
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="tipo_sesion" id="pareja" value="2">
                                        <label class="custom-control-label" for="pareja">
                                            En Pareja
                                        </label>
                                    </div>
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
                                <div class="col-sm-4">
                                    <label for="dia">Día(*)</label>
                                    <input type="date" class="form-control" id="dia" name="dia" placeholder="dia" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="hora_inicio">Hora Inicio(*)</label>
                                    <input class="form-control" type="time" id="hora_inicio" name="hora_inicio" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="hora_fin">Hora Fin(*)</label>
                                    <input class="form-control" type="time" id="hora_fin" name="hora_fin" required>
                                </div>
                                <div class="col-sm-4">
            
                                </div>
                            </div>
                            <h7 style="color: red; font-size: 14px;">Los campos marcados con (*) son obligatorios.</h7>
                        </div>

                        <div class="modal-footer">
                            <span class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</span> <!--se pone span por el onSubmit, si se da clic en cerrar tambien se guardaria el paciente-->
                            <button class="btn btn-outline-primary">Guardar Datos</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>                   
    </body>
</html>