<?php
	$idSesionEditar = $_POST['idSesionEditar'];
	include "../../clases/Sesiones.php";
	$Sesiones = new Sesiones();
	echo json_encode($Sesiones -> obtenerDatosSesionEditar($idSesionEditar));