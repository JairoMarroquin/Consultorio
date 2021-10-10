<?php
    include "../../../clases/Usuarios.php";
    $Usuarios = new Usuarios();

    $idUsuarioDesactivar = $_POST['id'];
    echo $Usuarios -> desactivarUsuario($idUsuarioDesactivar);
?>