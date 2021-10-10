<?php
session_start();
include "../../clases/Conexion.php";
$con = new Conexion();
$conexion = $con->conectar(); 
$sqlGeneral="select
                usuarios.id_usuario as idPsicologo, 
                usuarios.primer_nombre as nombrePsicologo, 
                usuarios.apellido_paterno as apellidoPsicologo,
                usuarios.apellido_materno as apellidoMaternoPsicologo, 
                pacientes.id_psicologo as idPsicologoPaciente,
                pacientes.id_paciente as idPaciente, 
                pacientes.primer_nombre as nombrePaciente, 
                pacientes.segundo_nombre as segundoNombre, 
                pacientes.apellido_paterno as apellidoPaciente, 
                pacientes.apellido_materno as apellidoMaterno,
                pacientes.id_estatus as estatusPaciente, 
                pacientes.fecha_nacimiento,
                pacientes.primera_vez, 
                pacientes.sexo, 
                pacientes.telefono, 
                pacientes.correo,
                pacientes.eliminado,
                estatusPaciente.id_estatus as idEstatusPaciente,
                estatusPaciente.descripcion
            from pacientes as pacientes 
                inner join 
            usuarios as usuarios on pacientes.id_psicologo = usuarios.id_usuario 
                INNER JOIN
            estatus_paciente AS estatusPaciente ON pacientes.id_estatus = estatusPaciente.id_estatus
            ORDER BY pacientes.id_paciente";

$respuestaGeneral = mysqli_query($conexion, $sqlGeneral);
?>

<table class="table table-sm table-hover table-responsive dt-responsive nowrap table-striped" style="width:100%" id="tablaPacientesDataTable">
    <thead>
        <th >ID</th>
        <th>Paciente</th>
        <th>Psicólogo asignado</th>
        <th>Fecha Nacimiento</th>
        <th >Correo</th>
        <th >Teléfono</th>
        <th >Estatus</th>
        <th >Sexo</th>
        <th >Primera Vez</th>
        <th >Quitar Primera Vez</th>
        <th >Acciones</th>
    </thead>
    <tbody>
        <?php
            while($mostrar = mysqli_fetch_array($respuestaGeneral)) { 
                if($mostrar['eliminado'] < 1 && $mostrar['estatusPaciente'] == 1 && $_SESSION['usuario']['rol'] == 1){     
        ?>

        <tr>
            <td><?php echo $mostrar['idPaciente'];?></td>
            <!-- Concateno el nombre y apellido del paciente-->
            <td><?php echo $mostrar['nombrePaciente']?> <?php $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombre']; ?> <?php echo $mostrar['apellidoPaciente'];?> <?php echo $mostrar['apellidoMaterno'];?></td>
            <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['apellidoPsicologo'];?> <?php echo $mostrar['apellidoMaternoPsicologo'];?><!--(<?php echo $mostrar['idPsicologo']?>)--> </td>
            <td><?php echo $mostrar['fecha_nacimiento'];?></td>
            <td><?php echo $mostrar['correo'];?></td>
            <td><?php echo $mostrar['telefono'];?></td>
            <td><?php echo $mostrar['descripcion']?></td>  
            <td><?php echo $mostrar['sexo'];?></td>
            <td><?php if($mostrar['primera_vez'] == 1){echo 'Si';}else{echo 'No';}?></td> 
                <?php
                    if($mostrar['primera_vez'] == 1){ //si es primera vez muestra el boton para cambiar ese estatus
                ?>
                    <td>
                        <h3><button class="btn btn-outline-primary badge badge-pill" style="width: 60px;" onClick="confirmDeleteFirstTime(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-exchange-alt"></span></button></h3>
                    </td>   
                <?php 
                    }elseif($mostrar['primera_vez'] == 0){ //si no es primera vez muestra mensaje que no se puede cambiar estatus
                ?>
                    <td>No se puede quitar</td>
                    
                <?php 
                    }
                ?>
            <td><h3> <!--boton EDITAR-->
                <button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#modalEditarPaciente" onClick="obtenerDatosPacienteEditar(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-user-edit"></span></span></button> 
                <!-- boton ELIMINAR-->
                <button class="btn btn-outline-danger badge badge-pill" style="width: 60px;" onclick="return confirmDelete(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-trash-alt"></span></button>
            </h3></td>    
        </tr>
        <?php 
        }elseif($_SESSION['usuario']['id'] == $mostrar['idPsicologoPaciente']){?>
            <tr>
                <td><?php echo $mostrar['idPaciente'];?></td>
                <!-- Concateno el nombre y apellido del paciente-->
                <td><?php echo $mostrar['nombrePaciente']?> <?php $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombre']; ?> <?php echo $mostrar['apellidoPaciente'];?> <?php echo $mostrar['apellidoMaterno'];?></td>
                <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['apellidoPsicologo'];?> <?php echo $mostrar['apellidoMaternoPsicologo'];?><!--(<?php echo $mostrar['idPsicologo']?>)--> </td>
                <td><?php echo $mostrar['fecha_nacimiento'];?></td>
                <td><?php echo $mostrar['correo'];?></td>
                <td><?php echo $mostrar['telefono'];?></td>
                <td><?php echo $mostrar['descripcion']?></td>  
                <td><?php echo $mostrar['sexo'];?></td>
                <td><?php if($mostrar['primera_vez'] == 1){echo 'Si';}else{echo 'No';}?></td> 
                    <?php
                        if($mostrar['primera_vez'] == 1){ //si es primera vez muestra el boton para cambiar ese estatus
                    ?>
                        <td>
                            <h3><button class="btn btn-outline-primary badge badge-pill" style="width: 60px;" onClick="confirmDeleteFirstTime(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-exchange-alt"></span></button></h3>
                        </td>   
                    <?php 
                        }elseif($mostrar['primera_vez'] == 0){ //si no es primera vez muestra mensaje que no se puede cambiar estatus
                    ?>
                        <td>No se puede quitar</td>
                        
                    <?php 
                        }
                    ?>
                <td><h3> <!--boton EDITAR-->
                    <button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#modalEditarPaciente" onClick="obtenerDatosPacienteEditar(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-user-edit"></span></span></button> 
                    <!-- boton ELIMINAR-->
                    <button class="btn btn-outline-danger badge badge-pill" style="width: 60px;" onclick="return confirmDelete(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-trash-alt"></span></button>
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
        $('#tablaPacientesDataTable').DataTable({
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