<?php
    include "../../clases/Usuarios.php";
    $Usuarios = new Usuarios();
    $idPaciente=$_POST['id'];
    
    echo $Usuarios -> editarPrimeraVez($idPaciente);
        
?>