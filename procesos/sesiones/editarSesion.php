<?php

include "../../clases/Sesiones.php";
$Sesiones = new Sesiones();

$datos= array(
		'idSesionEditar'=>$_POST['idSesionEditar'],
		'cita'=>$_POST['citau'],
		'tipo_sesion'=>$_POST['tipo_sesionu'],
		'dia'=>$_POST['diau'],
		'hora_inicio'=>$_POST['hora_iniciou'],
		'hora_fin'=>$_POST['hora_finu']
);

echo $Sesiones->editarSesion($datos);