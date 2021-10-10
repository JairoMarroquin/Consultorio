<?php
    include "../../clases/Usuarios.php";
    $Usuarios = new Usuarios();
    $idPacienteEliminar= $_POST['id'];
    
    echo $Usuarios -> eliminarPaciente($idPacienteEliminar);
?>