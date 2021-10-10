<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <?php
    $q2=intval($_GET['q']);
    include "../../clases/Conexion.php";
    $con2 = new Conexion();
    $conexion2 = $con2->conectar();
    $sql2= "SELECT 
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
            AND id_paciente =  '$q2'";
    $respuesta2 = mysqli_query($conexion2, $sql2);

        while($row2= mysqli_fetch_array($respuesta2)){
            echo "". $row2['nombrePsic']." ".$row2['segundoNombrePsic']." ".$row2['apellidoPaternoPsic']." ".$row2['apellidoMaternoPsic'];
        }

?>
</body>
</html>