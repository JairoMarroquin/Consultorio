<?php
include "../../clases/Citas.php";

$datos = array(
    "id_paciente" => $_POST['paciente'],
    "tipo_sesion" => $_POST['tipo_sesion'],
    "dia" =>$_POST['dia'],
    "hora_cita" =>$_POST['hora_cita'],
    "notas" => $_POST['notas']
);

$Citas = new Citas();
echo $Citas-> agregarCita($datos);
?>