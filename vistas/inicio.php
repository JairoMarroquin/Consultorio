<?php
ob_start();
include "header.php";
date_default_timezone_set("America/Monterrey");
$idUsuario = $_SESSION['usuario']['id'];
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] > 0){ 
  include "../clases/Conexion.php";
  $con = new Conexion();
  $conexion = $con->conectar();
  if($idUsuario == 1){
    $sql="SELECT 
            citas.id_cita AS idCita,
            citas.id_paciente AS idPaciente,
            citas.id_psicologo AS idPsicologoCita,
            citas.atendida,
            citas.eliminada,
            citas.tipo_sesion AS tipoSesion,
            citas.fecha_dia AS dia,
            citas.fecha_hora AS hora,
            citas.notas,
            pacientes.id_paciente,
            pacientes.primer_nombre AS nombrePaciente,
            pacientes.segundo_nombre AS segundoNombrePaciente,
            pacientes.apellido_paterno AS paternoPaciente,
            pacientes.apellido_materno AS maternoPaciente,
            pacientes.eliminado,
            psicologo.id_usuario as idPsicologo,
            psicologo.primer_nombre as nombrePsicologo,
            psicologo.segundo_nombre as segundoNombrePsicologo,
            psicologo.apellido_paterno as paternoPsicologo,
            psicologo.apellido_materno as maternoPsicologo,
            tipoSesion.id_tipoSesion as idTipoSesion,
            tipoSesion.nombre as nombreSesion
          FROM
            citas AS citas
                INNER JOIN
            pacientes AS pacientes ON citas.id_paciente = pacientes.id_paciente
                Inner join
            usuarios as psicologo ON citas.id_psicologo = psicologo.id_usuario
                INNER JOIN
            tipo_sesion as tipoSesion ON citas.tipo_sesion = tipoSesion.id_tipoSesion
          WHERE citas.atendida = 0 AND citas.eliminada = 0
          ORDER by dia, hora";
  }else{
    $sql="SELECT 
            citas.id_cita AS idCita,
            citas.id_paciente AS idPaciente,
            citas.id_psicologo AS idPsicologoCita,
            citas.atendida,
            citas.eliminada,
            citas.tipo_sesion AS tipoSesion,
            citas.fecha_dia AS dia,
            citas.fecha_hora AS hora,
            citas.notas,
            pacientes.id_paciente,
            pacientes.primer_nombre AS nombrePaciente,
            pacientes.segundo_nombre AS segundoNombrePaciente,
            pacientes.apellido_paterno AS paternoPaciente,
            pacientes.apellido_materno AS maternoPaciente,
            pacientes.eliminado,
            psicologo.id_usuario as idPsicologo,
            psicologo.primer_nombre as nombrePsicologo,
            psicologo.segundo_nombre as segundoNombrePsicologo,
            psicologo.apellido_paterno as paternoPsicologo,
            psicologo.apellido_materno as maternoPsicologo,
            tipoSesion.id_tipoSesion as idTipoSesion,
            tipoSesion.nombre as nombreSesion
          FROM
            citas AS citas
                INNER JOIN
            pacientes AS pacientes ON citas.id_paciente = pacientes.id_paciente
                Inner join
            usuarios as psicologo ON citas.id_psicologo = psicologo.id_usuario
                INNER JOIN
            tipo_sesion as tipoSesion ON citas.tipo_sesion = tipoSesion.id_tipoSesion
          WHERE citas.atendida = 0 AND citas.eliminada = 0 AND citas.id_psicologo = '$idUsuario'
          ORDER by dia, hora";
  }

  $respuesta = mysqli_query($conexion, $sql);
  $numeroCitas = mysqli_num_rows($respuesta); //cuenta la cantidad de citas pendientes que hay
  $fechaActual= date("Y-m-d H:i");
  ?>

    <div class="container" style = "width: 200%;">
      <div class="card border-0 shadow my-5">
        <div class="card-body p-5">
          <h2 class="fw-light">Inicio</h2>
          <hr>
          <h4 class="fw-light">Citas pendientes</h4>
            <?php
            if($numeroCitas == 0 && $_SESSION['usuario']['rol'] == 1){
              ?><h4 style="text-align: center; color: #630000; margin-top:10%; text-decoration: underline;"><a href="../vistas/citas.php">No hay citas pendientes.</a></h4><?php
            }elseif($numeroCitas == 0 &&  $_SESSION['usuario']['rol'] > 1){
              ?><h4 style="text-align: center; color: #630000; margin-top:10%; text-decoration: underline;"><a href="../vistas/misCitas.php">No hay citas pendientes para ti.</a></h4><?php
            }else{
              for ($i=1; $i < 6; $i++) {
                while($citas = mysqli_fetch_array($respuesta)){
                    if($_SESSION['usuario']['id'] == 1 && $citas['eliminado'] == 0){
                ?>
                    <div class="card text-center text-dark bg-light" id="tarjeta_cita_pendiente_inicio">
                      <div class="card-body">
                        <h5 class="card-header mb-2"><?php echo $citas['nombrePaciente'];?> <?php echo $citas['segundoNombrePaciente'];?> <?php echo $citas['paternoPaciente'];?> <?php echo $citas['maternoPaciente'];?></h5>
                        <h7 class="card-title text-muted" id="nombrePsic"><?php echo $citas['nombrePsicologo'];?> <?php echo $citas['segundoNombrePsicologo'];?> <?php echo $citas['paternoPsicologo'];?> <?php echo $citas['maternoPsicologo'];?></h7>
                        <p class="card-text mb-2 text-muted" id="datosSesion">
                          <?php
                          $fechaDiaVencimiento = $citas['dia'];
                          $fechaHoraVencimiento = $citas['hora'];
                          $fechaDiaVencimientoFormato= date_create($fechaDiaVencimiento); //creo el objeto fecha para el DIA
                          $fechaVencimientoFinal = date_format($fechaDiaVencimientoFormato, 'd-m-Y'); //le doy el formato a la fecha
                          $fechaVencimiento = $fechaDiaVencimiento.' '.$fechaHoraVencimiento;

                            if($fechaActual > $fechaVencimiento){ //si la cita esta vencida que marque la fecha en rojo
                          ?>
                          <span class="fecha_vencida"><?php echo $fechaVencimientoFinal;?> <?php echo $citas['hora'];?></span>, <?php echo $citas['nombreSesion'];?>
                          <?php
                            }else{
                          ?>
                          <span class="fecha_cita"><?php echo $fechaVencimientoFinal;?> <?php echo $citas['hora'];?></span>, <?php echo $citas['nombreSesion'];?>
                          <?php
                            }
                          ?>
                        </p>
                        <p class="card-text"><?php if($citas['notas'] == ''){echo 'Sin notas';}else{echo $citas['notas'];}?></p>
                        <a href="../vistas/citas.php">Ir a Citas</a>
                      </div>
                    </div>
                <?php 
                    }elseif($_SESSION['usuario']['id'] == $citas['idPsicologo'] && $citas['eliminado'] == 0){
                      ?>
                          <div class="card text-center text-dark bg-light" id="tarjeta_cita_pendiente_inicio">
                            <div class="card-body">
                              <h5 class="card-header mb-2"><?php echo $citas['nombrePaciente'];?> <?php echo $citas['segundoNombrePaciente'];?> <?php echo $citas['paternoPaciente'];?> <?php echo $citas['maternoPaciente'];?></h5>
                              <h6 class="card-title text-muted" id="nombrePsic"><?php echo $citas['nombrePsicologo'];?> <?php echo $citas['segundoNombrePsicologo'];?> <?php echo $citas['paternoPsicologo'];?> <?php echo $citas['maternoPsicologo'];?></h6>
                              <p class="card-text mb-2 text-muted" id="datosSesion">
                                <?php
                                $fechaDiaVencimiento = $citas['dia'];
                                $fechaHoraVencimiento = $citas['hora'];
                                $fechaDiaVencimientoFormato= date_create($fechaDiaVencimiento); //creo el objeto fecha para el DIA
                                $fechaVencimientoFinal = date_format($fechaDiaVencimientoFormato, 'd-m-Y'); //le doy el formato a la fecha
                                $fechaVencimiento = $fechaDiaVencimiento.' '.$fechaHoraVencimiento;
                                  if($fechaActual > $fechaVencimiento){ //si la cita esta vencida que marque la fecha en rojo
                                ?>
                                <span class="fecha_vencida"><?php echo $fechaVencimientoFinal;?> <?php echo $citas['hora'];?></span>, <?php echo $citas['nombreSesion'];?>
                                <?php
                                  }else{
                                ?>
                                <span class="fecha_cita"><?php echo $fechaVencimientoFinal;?> <?php echo $citas['hora'];?></span>, <?php echo $citas['nombreSesion'];?>
                                <?php
                                  }
                                ?>
                              </p>
                              <p class="card-text"><?php if($citas['notas'] == ''){echo 'Sin notas';}else{echo $citas['notas'];}?></p>
                              <a href="../vistas/misCitas.php">Ir a Citas</a>
                            </div>
                          </div>
                      <?php                                  
                  }
                }
              }
            }
          
            include "footer.php";
          ?>
      </div>
    </div>
  <?php
}else{//se cierra la validacion del if
  header('location: ../');
} 
ob_end_flush();
  ?>