<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <?php
    $q=intval($_GET['q']);
    include "../../clases/Conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
    $sql1= "SELECT 
                usuarios.id_usuario as idPsic,
                usuarios.primer_nombre as nombrePsic,
                usuarios.segundo_nombre as segundoNombrePsic,
                usuarios.apellido_paterno as apellidoPaternoPsic,
                usuarios.apellido_materno as apellidoMaternoPsic,
                pacientes.id_psicologo as idPacientePsic,
                pacientes.id_paciente as idPaciente
            FROM
                usuarios as usuarios
            INNER JOIN
                pacientes as pacientes
            ON pacientes.id_psicologo = usuarios.id_usuario
            AND id_paciente =  '$q'";
    $respuesta1 = mysqli_query($conexion, $sql1);

        while($row= mysqli_fetch_array($respuesta1)){
            echo "". $row['nombrePsic']." ".$row['segundoNombrePsic']." ".$row['apellidoPaternoPsic']." ".$row['apellidoMaternoPsic'];
        }

?>
</body>
</html>