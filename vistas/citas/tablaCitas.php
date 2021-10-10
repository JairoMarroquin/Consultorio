<?php
session_start();
include "../../clases/Conexion.php";
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
        tipo_sesion as tipoSesion ON citas.tipo_sesion = tipoSesion.id_tipoSesion";

$respuesta = mysqli_query($conexion, $sql);
?>

<table class="table table-sm table-hover table-responsive dt-responsive nowrap" style="width:100%" id="tablaCitasDataTable">
    <thead>
        <th> ID </th>
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
    ?>
        <tr>
            <td><?php echo $mostrar['idCita'];?></td>
            <td><?php echo $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombrePaciente'];?> <?php echo $mostrar['paternoPaciente'];?> <?php echo $mostrar['maternoPaciente'];?></td>
            <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['segundoNombrePsicologo'];?> <?php echo $mostrar['paternoPsicologo'];?> <?php echo $mostrar['maternoPsicologo'];?></td>
            <td><?php echo $mostrar['nombreSesion'];?></td>
            <td><?php echo $mostrar['dia'];?> <?php echo $mostrar['hora']?></td>
            <td><?php echo $mostrar['notas']?></td>
            <td><h3>
                <button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#editarCitas" onClick="obtenerDatosEditarCita(<?php echo $mostrar['idCita'];?>)"><span class="far fa-edit"></span></button>
                <button class="btn btn-outline-danger badge badge-pill" style="width: 60px;" onclick="return confirmDelete(<?php echo $mostrar['idCita'];?>);"><span class="far fa-calendar-times"></span></button>
            </h3></td>
        </tr>

        <?php
        }elseif($_SESSION['usuario']['id'] == $mostrar['idPsicologo'] && $mostrar['eliminada'] == 0 && $mostrar['atendida'] == 0){
            ?>
            <tr>
            <td><?php echo $mostrar['idCita'];?></td>
            <td><?php echo $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombrePaciente'];?> <?php echo $mostrar['paternoPaciente'];?> <?php echo $mostrar['maternoPaciente'];?></td>
            <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['segundoNombrePsicologo'];?> <?php echo $mostrar['paternoPsicologo'];?> <?php echo $mostrar['maternoPsicologo'];?></td>
            <td><?php echo $mostrar['nombreSesion'];?></td>
            <td><?php echo $mostrar['dia'];?> <?php echo $mostrar['hora']?></td>
            <td><?php echo $mostrar['notas']?></td>
            <td><h3>
                <button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#editarCitas" onClick="obtenerDatosEditarCita(<?php echo $mostrar['idCita'];?>)"><span class="far fa-edit"></span></button>
                <button class="btn btn-outline-danger badge badge-pill" style="width: 60px;" onclick="return confirmDelete(<?php echo $mostrar['idCita'];?>);"><span class="far fa-calendar-times"></span></button>
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