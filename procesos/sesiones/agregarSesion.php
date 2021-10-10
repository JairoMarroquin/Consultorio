<?php
include "../../clases/Sesiones.php";


$datos= array(
    "id_paciente" => $_POST['paciente'],
    "cita"=> $_POST['cita'],
    "tipo_sesion"=> $_POST['tipo_sesion'],
    "dia"=> $_POST['dia'],
    "hora_inicio"=> $_POST['hora_inicio'],
    "hora_fin"=> $_POST['hora_fin']
);

$Sesiones = new Sesiones();
echo $Sesiones->agregaNuevaSesion($datos);
?>