<?php
    include "../../../clases/Usuarios.php";
    $Usuarios = new Usuarios();

    $idUsuarioActivar = $_POST['id'];
    echo $Usuarios -> activarUsuario($idUsuarioActivar);
?>