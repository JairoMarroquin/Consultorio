<?php
include "../../clases/Conexion.php";
$con = new Conexion();
$conexion = $con->conectar();
$sql = "SELECT * FROM tecnicas";
$respuesta = mysqli_query($conexion, $sql);

?>

<table class="table table-sm table-hover table-responsive dt-responsive nowrap table-striped" style="width:100%" id="tablaTecnicasDataTable">
    <thead>
        <th>ID</th>
        <th>Técnica</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php
            while($mostrar = mysqli_fetch_array($respuesta)){
        ?>
        <tr>
            <td><?php echo $mostrar['id_tecnica'];?></td>
            <td><?php echo $mostrar['nombre'];?></td>
            <td>
            <button class="btn btn-outline-info badge badge-pill" style="width: 60px;"><span class="fas fa-edit"></span></button>
            <button class="btn btn-outline-danger badge badge-pill" style="width: 60px;"><span class="fas fa-trash-alt"></span></button>
            </td>
            </tr>
        <?php
            }
        ?>  
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#tablaTecnicasDataTable').DataTable({
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