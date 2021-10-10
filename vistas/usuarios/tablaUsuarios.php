<?php
session_start();
include "../../clases/Conexion.php";
$con = new Conexion();
$conexion = $con->conectar();
$sql="SELECT 
        usuarios.id_usuario as idUsuario,
        usuarios.primer_nombre as primerNombre,
        usuarios.segundo_nombre as segundoNombre,
        usuarios.apellido_paterno as apellidoPaterno,
        usuarios.apellido_materno as apellidoMaterno,
        usuarios.bit_psicologo as psicologo,
        usuarios.fecha_alta as fechaAlta,
        usuarios.bit_activo as activo,
        usuarios.id_rol as usuarioRol,
        rol.id_rol,
        rol.nombre as rolNombre
        FROM
        usuarios AS usuarios
            INNER JOIN
        rol AS rol ON usuarios.id_rol = rol.id_rol
        ORDER BY usuarios.id_usuario";
$respuesta = mysqli_query($conexion, $sql);

?>

<table class="table table-sm table-hover table-responsive dt-responsive nowrap" style="width:100%" id="tablaUsuariosDataTable">
    <thead>
        <th>ID</th>
        <th>Nombre de Usuario</th>
        <th>¿Es psicólogo?</th>
        <th>Rol</th>
        <th>Fecha de Alta</th>
        <th>Editar</th>
        <th>Activar/Desactivar</th>
    </thead>
    <tbody>

    <?php
        while($mostrar= mysqli_fetch_array($respuesta)){
            if($mostrar['idUsuario'] != $_SESSION['usuario']['id']){ //validacion que no muestre el usuario que inicio sesion en la tabla
    ?>
        <tr>
            <td><?php echo $mostrar['idUsuario'];?></td>
            <td><?php echo $mostrar['primerNombre'];?> <?php echo $mostrar['segundoNombre'];?> <?php echo $mostrar['apellidoPaterno'];?> <?php echo $mostrar['apellidoMaterno'];?></td>
            <td><?php if($mostrar['psicologo'] == 1){echo 'Si';}else{echo 'No';}?></td>
            <td><?php echo $mostrar['rolNombre']?></td>
            <td><?php echo $mostrar['fechaAlta'];?></td>
            <?php
                if($_SESSION['usuario']['rol'] == 1){ //validacion para evitar que admin y colaboradores editen usuario super admin
            ?>
            <td><h3><button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#modalEditarUsuarios" onClick="obtenerDatosUsuario(<?php echo $mostrar['idUsuario'];?>)"><span class="fas fa-user-edit"></span></button></h3></td>
                <?php
                }elseif($_SESSION['usuario']['rol'] == 2 && $mostrar['usuarioRol'] > 2){ //si es admin solo puede editar colaboradores
                ?>
            <td><h3><button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#modalEditarUsuarios" onClick="obtenerDatosUsuario(<?php echo $mostrar['idUsuario'];?>)"><span class="fas fa-user-edit"></span></button></h3></td>   
                <?php
                }elseif($_SESSION['usuario']['rol'] == 3 && $mostrar['usuarioRol'] == $_SESSION['usuario']['id_rol']){ //colaboradores solo se pueden editar ellos mismos
                ?>
                <td><h3><button class="btn btn-outline-info badge badge-pill" style="width: 60px;" data-toggle="modal" data-target="#modalEditarUsuarios" onClick="obtenerDatosUsuario(<?php echo $mostrar['idUsuario'];?>)"><span class="fas fa-user-edit"></span></button></h3></td>
                <?php
                }else{
                ?>
            <td> </td>

            <?php
                }
            ?>
            <?php
                if($mostrar['activo'] == 1 && $mostrar['idUsuario'] > 1){
            ?>
                <td><h3><button class="btn btn-outline-danger badge badge-pill" style="width: 60px;" onClick="return confirmDelete(<?php echo $mostrar['idUsuario'];?>)"><span class="fas fa-minus-circle"></span></button></h3></td>
            <?php }elseif($mostrar['activo'] == 0){
            ?>
                <td><h3><button class="btn btn-outline-primary badge badge-pill" style="width: 60px;" onClick="return confirmActivate(<?php echo $mostrar['idUsuario'];?>)"><span class="fas fa-plus-circle"></span></button></h3></td>
            <?php }else{ ?>
                <td> </td> <!-- Se inserta una celda vacia cuando el idUsuario==1 osea el super admin-->
                <?php }?>
        </tr>

    <?php 
    }
}
    ?>
    </tbody>
</table>


<script>
    $(document).ready(function(){
        $('#tablaUsuariosDataTable').DataTable({
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página.",
            "zeroRecords": "No existen registros.",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No existen paginas de registros.",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Buscar coincidencias: ",
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