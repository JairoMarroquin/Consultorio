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
            estatus_paciente AS estatusPaciente ON pacientes.id_estatus = estatusPaciente.id_estatus";

$respuestaGeneral = mysqli_query($conexion, $sqlGeneral);
?>

<table class="table table-sm table-hover table-responsive dt-responsive nowrap table-striped" style="width:100%" id="tablaPacientesDataTable">
    <thead>
        <th>Paciente</th>
        <th>Psicólogo asignado</th>
        <th>Estatus</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <th>Edad</th>
        <th>Sexo</th>
        <th>Primera Vez</th>
        <th></th>
        <th>Quitar Primera Vez</th>
    </thead>
    <tbody>
        <?php
            while($mostrar = mysqli_fetch_array($respuestaGeneral)) { 
                if($mostrar['eliminado'] == 0 && $_SESSION['usuario']['rol'] == 1 && $mostrar['estatusPaciente'] > 0){
                    $fecha_nacimiento = $mostrar['fecha_nacimiento'];
                    $fecha_actual = date("Y-m-d");
                    $edad_diff = date_diff(date_create($fecha_nacimiento), date_create($fecha_actual));
                    $edad = $edad_diff->format('%y');
        ?>

        <tr>
            <td><?php echo $mostrar['nombrePaciente']?> <?php $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombre']; ?> <?php echo $mostrar['apellidoPaciente'];?> <?php echo $mostrar['apellidoMaterno'];?></td>
            <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['apellidoPsicologo'];?> <?php echo $mostrar['apellidoMaternoPsicologo'];?><!--(<?php echo $mostrar['idPsicologo']?>)--> </td>
            <?php if($mostrar['idEstatusPaciente'] == 1){?><td style="color:#00B000;"><?php echo $mostrar['descripcion'];?></td><?php }elseif($mostrar['idEstatusPaciente'] == 4){ ?> <td style="color:#F39C12;"><?php echo $mostrar['descripcion'];?></td><?php }elseif($mostrar['idEstatusPaciente'] == 3){?> <td style="color:#0007cc;"><?php echo $mostrar['descripcion'];?></td><?php }else{?><td style="color:#ff1212;"><?php echo $mostrar['descripcion'];?></td> <?php } ?>
            <td><?php echo $mostrar['correo'];?></td>
            <td><?php echo $mostrar['telefono'];?></td>
            <td><?php echo $edad;?> años</td>
            <td><?php echo $mostrar['sexo'];?></td>
            <td align="center"><?php if($mostrar['primera_vez'] == 1){?> <i style="color:#12b300;" class="fas fa-check"></i> <?php }else{?> <i style="color:#bf000a;" class="fas fa-times"></i> <?php }?></td>
            <td>
                <form action="GET">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                        <ul class="dropdown-menu" id="optPac" aria-labelledby="dropdownMenuButton1">
                            <li><h6 class="dropdown-header">Acciones</h6></li>
                            <li><a href="" data-bs-toggle="modal" data-bs-target="#modalEditarPaciente" onClick="obtenerDatosPacienteEditar(<?php echo $mostrar['idPaciente'];?>)" class="dropdown-item">Editar</a></li>
                            <li><a href="../procesos/reportes/reportePacienteGeneral.php?pacid= <?php echo $mostrar['idPaciente'];?>" target="_blank" class="dropdown-item">Reporte Individual</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="" style="color:#bf000a;"onclick="return confirmDelete(<?php echo $mostrar['idPaciente'];?>)" class="dropdown-item">Eliminar</a></li>
                        </ul>
                    </div>
                </form>
            </td>  
                <?php
                    if($mostrar['primera_vez'] == 1){ //si es primera vez muestra el boton para cambiar ese estatus
                ?>
                    <td>
                        <h3><button class="btn btn-outline-primary" style="width: 60px;" onClick="confirmDeleteFirstTime(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-exchange-alt"></span></button></h3>
                    </td>  
                <?php 
                    }elseif($mostrar['primera_vez'] == 0){ //si no es primera vez muestra mensaje que no se puede cambiar estatus
                ?>
                    <td>No se puede quitar</td>
                    
                <?php 
                    }
                ?>
        </tr>
        <?php 
        }elseif($_SESSION['usuario']['id'] == $mostrar['idPsicologoPaciente']){
            $fecha_nacimiento = $mostrar['fecha_nacimiento'];
            $fecha_actual = date("Y-m-d");
            $edad_diff = date_diff(date_create($fecha_nacimiento), date_create($fecha_actual));
            $edad = $edad_diff->format('%y');
            ?>

            <tr>
                <td><?php echo $mostrar['nombrePaciente']?> <?php $mostrar['nombrePaciente'];?> <?php echo $mostrar['segundoNombre']; ?> <?php echo $mostrar['apellidoPaciente'];?> <?php echo $mostrar['apellidoMaterno'];?></td>
                <td><?php echo $mostrar['nombrePsicologo'];?> <?php echo $mostrar['apellidoPsicologo'];?> <?php echo $mostrar['apellidoMaternoPsicologo'];?><!--(<?php echo $mostrar['idPsicologo']?>)--> </td>
                <?php if($mostrar['idEstatusPaciente'] == 1){?><td style="color:#00B000;"><?php echo $mostrar['descripcion'];?></td><?php }elseif($mostrar['idEstatusPaciente'] == 4){ ?> <td style="color:#F39C12;"><?php echo $mostrar['descripcion'];?></td><?php }elseif($mostrar['idEstatusPaciente'] == 3){?> <td style="color:#0007cc;"><?php echo $mostrar['descripcion'];?></td><?php }else{?><td style="color:#ff1212;"><?php echo $mostrar['descripcion'];?></td> <?php } ?>
                <td><?php echo $mostrar['correo'];?></td>
                <td><?php echo $mostrar['telefono'];?></td>
                <td><?php echo $edad;?> años</td>
                <td><?php echo $mostrar['sexo'];?></td>
                <td align="center"><?php if($mostrar['primera_vez'] == 1){?> <i style="color:#12b300;" class="fas fa-check"></i> <?php }else{?> <i style="color:#bf000a;" class="fas fa-times"></i> <?php }?></td>
                <td>
                    <form method="GET">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <ul class="dropdown-menu" id="optPac" aria-labelledby="dropdownMenuButton1">
                                <li><h6 class="dropdown-header">Acciones</h6></li>
                                <li><a href="" data-bs-toggle="modal" data-bs-target="#modalEditarPaciente" onClick="obtenerDatosPacienteEditar(<?php echo $mostrar['idPaciente'];?>)" class="dropdown-item">Editar</a></li>
                                <li><a href="../procesos/reportes/reportePacienteGeneral.php?pacid= <?php echo $mostrar['idPaciente'];?>"class="dropdown-item">Reporte Individual</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="" style="color:#bf000a;"onclick="return confirmDelete(<?php echo $mostrar['idPaciente'];?>)" class="dropdown-item">Eliminar</a></li>
                            </ul>
                        </div>
                    </form>
                </td>
                
                    <?php
                        if($mostrar['primera_vez'] == 1){ //si es primera vez muestra el boton para cambiar ese estatus
                    ?>
                        <td>
                            <h3><button class="btn btn-outline-primary" style="width: 60px;" onClick="confirmDeleteFirstTime(<?php echo $mostrar['idPaciente'];?>)"><span class="fas fa-exchange-alt"></span></button></h3>
                        </td>   
                    <?php 
                        }elseif($mostrar['primera_vez'] == 0){ //si no es primera vez muestra mensaje que no se puede cambiar estatus
                    ?>
                        <td>No se puede quitar</td>
                        
                    <?php 
                        }
                    ?>  
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