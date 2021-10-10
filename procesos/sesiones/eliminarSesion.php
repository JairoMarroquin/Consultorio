<?php
    include "../../clases/Sesiones.php";
    $Sesiones = new Sesiones();

    $idSesionEliminar = $_POST['id'];
    echo $Sesiones->eliminarSesion($idSesionEliminar);  
?>