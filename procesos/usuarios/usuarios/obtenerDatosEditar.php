<?php
    $idUsuarioEditar= $_POST['idUsuarioEditar'];
    include "../../../clases/Usuarios.php";
    $Usuarios = new Usuarios();
    echo json_encode($Usuarios -> obtenerDatosUsuarioEditar($idUsuarioEditar));
?>