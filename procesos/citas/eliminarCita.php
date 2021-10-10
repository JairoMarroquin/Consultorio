<?php

$idCitaEliminar = $_POST['id'];
include "../../clases/Citas.php";
$Citas = new Citas();
echo $Citas->eliminarCita($idCitaEliminar);
?>