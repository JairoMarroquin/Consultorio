<?php

$datos = array(
   "primer_nombre" => $_POST['primer_nombre'],
   "segundo_nombre" => $_POST['segundo_nombre'],
   "apellido_paterno" => $_POST['apellido_paterno'],
   "apellido_materno" => $_POST['apellido_materno'],
   "fecha_nacimiento" => $_POST['fecha_nacimiento'],
   "sexo" => $_POST['sexo'],
   "telefono" => $_POST['telefono'],
   "correo" => $_POST['correo'], 
   "id_psicologo" => $_POST['psicologo_encargado']
);
    include "../../clases/Usuarios.php";
    $Usuarios = new Usuarios();

    echo $Usuarios->agregaNuevoPaciente($datos);

?>