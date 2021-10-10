<?php
    $idPacienteEditar= $_POST['idPacienteEditar'];
    include "../../clases/Usuarios.php";
    $Usuarios = new Usuarios();
    echo json_encode($Usuarios -> obtenerDatosPacienteEditar($idPacienteEditar));
