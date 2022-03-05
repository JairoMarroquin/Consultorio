<?php
session_start();
include "../../clases/Conexion.php";
date_default_timezone_set("America/Monterrey");
$con = new Conexion();
$conexion = $con->conectar();
$sql="SELECT 
        citas.id_cita AS idCita,
        citas.id_paciente AS idPaciente,
        citas.id_psicologo AS idPsicologo,
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
        ORDER BY citas.id_cita DESC";

$respuesta = mysqli_query($conexion, $sql);
$fechaActual= date("Y-m-d H:i");
?>

<table class="table table-sm table-hover table-responsive dt-responsive nowrap" style="width:100%" id="tablaCitasDataTable">
    <thead>
        <th> Paciente </th>
        <th> Psicólogo </th>
        <th> Tipo de Sesión </th>
        <th> Fecha </th>
        <th> Notas </th>
        <th> Acciones </th>
    </thead>
    <tbody>

    <?php
    while($mostrar = mysqli_fetch_array($respuesta)){
        if($_SESSION['usuario']['rol'] == 1 && $mostrar['eliminada'] == 0 && $mostrar['atendida'] == 0){
            $fechaCita = $mostrar['dia'].' '.$mostrar['hora']; 
    ?>
        <tr>
            <td><?php echo $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombrePaciente'];?> <?php echo $mostrar['paternoPaciente'];?> <?php echo $mostrar['maternoPaciente'];?></td>
            <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['segundoNombrePsicologo'];?> <?php echo $mostrar['paternoPsicologo'];?> <?php echo $mostrar['maternoPsicologo'];?></td>
            <td><?php echo $mostrar['nombreSesion'];?></td>
            <?php if($fechaActual > $fechaCita){ ?><td style="color:#e61405;font-weight:bolder;"><?php echo $fechaCita;?></td> <?php }else{ ?><td style="color:#009e11;font-weight:bolder;"><?php echo $fechaCita;?></td> <?php }?>
            <td><?php echo $mostrar['notas']?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                    <ul class="dropdown-menu" id="optCit" aria-labelledby="dropdownMenuButton1">
                        <li><h6 class="dropdown-header">Acciones</h6></li>
                        <li><a href="" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editarCitas" onClick="obtenerDatosEditarCita(<?php echo $mostrar['idCita'];?>)">Editar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="" style="color:red;" onclick="return confirmDelete(<?php echo $mostrar['idCita'];?>);" class="dropdown-item">Eliminar</a></li> 
                    </ul>
                </div>
            </td>
        </tr>

        <?php
        }elseif($_SESSION['usuario']['id'] == $mostrar['idPsicologo'] && $mostrar['eliminada'] == 0 && $mostrar['atendida'] == 0){
            $fechaCita = $mostrar['dia'].' '.$mostrar['hora']; 
            ?>
            <tr>
            <td><?php echo $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombrePaciente'];?> <?php echo $mostrar['paternoPaciente'];?> <?php echo $mostrar['maternoPaciente'];?></td>
            <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['segundoNombrePsicologo'];?> <?php echo $mostrar['paternoPsicologo'];?> <?php echo $mostrar['maternoPsicologo'];?></td>
            <td><?php echo $mostrar['nombreSesion'];?></td>
            <?php if($fechaActual > $fechaCita){ ?><td style="color:#e61405;font-weight:bolder;"><?php echo $fechaCita;?></td> <?php }else{ ?><td style="color:#009e11;font-weight:bolder;"><?php echo $fechaCita;?></td> <?php }?>
            <td><?php echo $mostrar['notas']?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                    <ul class="dropdown-menu" id="optCit" aria-labelledby="dropdownMenuButton1">
                        <li><h6 class="dropdown-header">Acciones</h6></li>
                        <li><a href="" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editarCitas" onClick="obtenerDatosEditarCita(<?php echo $mostrar['idCita'];?>)">Editar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="" style="color:red;" onclick="return confirmDelete(<?php echo $mostrar['idCita'];?>);" class="dropdown-item">Eliminar</a></li> 
                    </ul>
                </div>
            </td>
        </tr>
            <?php
        }
    }
        ?>
    </tbody>
</table>


<script>
    $(document).ready(function(){
        $('#tablaCitasDataTable').DataTable({
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página.",
            "zeroRecords": "No existen registros.",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No existen registros.",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Buscar coincidencias:",
            "processing": "Procesando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
        });
    });
</script>