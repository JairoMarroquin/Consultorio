<?php
session_start();
include "../../clases/Conexion.php";
$con= new Conexion();
$conexion = $con->conectar();
$sql= "SELECT 
        sesiones.id_sesion AS idSesion,
        sesiones.id_paciente AS idPaciente,
        sesiones.id_psicologo AS idPsicologo,
        sesiones.tipo_sesion AS tipoSesion,
        sesiones.fecha_dia as fechaDia,
        sesiones.fecha_hora_inicio as fechaHoraInicio,
        sesiones.fecha_hora_fin as fechaHoraFin,
        sesiones.cita,
        sesiones.mostrar,
        tipoSesion.id_TipoSesion AS idTipoSesion,
        tipoSesion.nombre AS sesionNombre,
        pacientes.id_paciente as idPaciente,
        pacientes.primer_nombre as nombrePaciente,
        pacientes.segundo_nombre as segundoNombrePaciente,
        pacientes.apellido_paterno as apellidoPaciente,
        pacientes.apellido_materno as apellidoMaternoPaciente,
        usuarios.id_usuario as idPsicologo,
        usuarios.primer_nombre as nombrePsicologo,
        usuarios.segundo_nombre as segundoNombrePsicologo,
        usuarios.apellido_paterno as apellidoPsicologo,
        usuarios.apellido_materno as apellidoMaternoPsicologo
        FROM
        sesiones AS sesiones
            INNER JOIN
        tipo_sesion AS tipoSesion ON sesiones.tipo_sesion = tipoSesion.id_tipoSesion
            inner join
        pacientes as pacientes ON sesiones.id_paciente =  pacientes.id_paciente
            inner join
        usuarios as usuarios ON sesiones.id_psicologo = usuarios.id_usuario
        ORDER BY id_sesion";

$respuesta = mysqli_query($conexion, $sql);

?>
<table class="table table-sm table-hover table-responsive dt-responsive nowrap" style="width:100%" id="tablaSesionesDataTable">
    <thead>
        <th>ID</th>
        <th>Paciente</th>
        <th>Psicólogo</th>
        <th>Tipo de Sesión</th>
        <th>Día</th>
        <th>Hora</th>
        <th>Sesión con Cita</th>
        <th>Acciones</th>
    </thead>

    <tbody>

    <?php 
    while($mostrar= mysqli_fetch_array($respuesta)){
        if($_SESSION['usuario']['rol'] == 1 && $mostrar['mostrar'] == 1){
    ?>
        <tr>
            <td><?php echo $mostrar['idSesion'];?></td>
            <td><?php echo $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombrePaciente'];?> <?php echo $mostrar['apellidoPaciente'];?> <?php echo $mostrar['apellidoMaternoPaciente'];?></td>
            <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['segundoNombrePsicologo'];?> <?php echo $mostrar['apellidoPsicologo'];?> <?php echo $mostrar['apellidoMaternoPsicologo'];?></td>
            <td><?php echo $mostrar['sesionNombre'];?></td>
            <td><?php echo $mostrar['fechaDia'];?></td>
            <td><?php echo $mostrar['fechaHoraInicio'];?> a <?php echo $mostrar['fechaHoraFin'];?></td>
            <td><?php if($mostrar['cita'] == 1){echo "SÍ";}else{echo "NO"; }?></td>
            <td><h3>
                <button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#modalEditarSesiones" onClick="obtenerDatosSesionEditar(<?php echo $mostrar['idSesion'];?>)"><span class="far fa-edit"></span></button>
                <button class="btn btn-outline-danger badge badge-pill" style="width: 60px;"onclick="return confirmDelete(<?php echo $mostrar['idSesion'];?>);"><span class="far fa-trash-alt"></span></button>
            </h3></td>
    </tr>     

    <?php 
        }elseif($_SESSION['usuario']['rol'] == $mostrar['idPsicologo'] && $mostrar['mostrar'] == 1){
            ?>
            <tr>
                <td><?php echo $mostrar['idSesion'];?></td>
                <td><?php echo $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombrePaciente'];?> <?php echo $mostrar['apellidoPaciente'];?> <?php echo $mostrar['apellidoMaternoPaciente'];?></td>
                <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['segundoNombrePsicologo'];?> <?php echo $mostrar['apellidoPsicologo'];?> <?php echo $mostrar['apellidoMaternoPsicologo'];?></td>
                <td><?php echo $mostrar['sesionNombre'];?></td>
                <td><?php echo $mostrar['fechaDia'];?></td>
                <td><?php echo $mostrar['fechaHoraInicio'];?> a <?php echo $mostrar['fechaHoraFin'];?></td>
                <td><?php if($mostrar['cita'] == 1){echo "SÍ";}else{echo "NO"; }?></td>
                <td><h3>
                    <button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#modalEditarSesiones" onClick="obtenerDatosSesionEditar(<?php echo $mostrar['idSesion'];?>)"><span class="far fa-edit"></span></button>
                    <button class="btn btn-outline-danger badge badge-pill" style="width: 60px;"onclick="return confirmDelete(<?php echo $mostrar['idSesion'];?>);"><span class="far fa-trash-alt"></span></button>
                </h3></td>
        </tr>     
    
        <?php 
        }
    }
    ?>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#tablaSesionesDataTable').DataTable({
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

