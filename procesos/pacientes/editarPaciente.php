<?php
$datos= array(
    'idPacienteEditar'=>$_POST['idPacienteEditar'],
    'primer_nombre'=>$_POST['primer_nombreu'],
    'segundo_nombre'=>$_POST['segundo_nombreu'],
    'apellido_paterno'=>$_POST['apellido_paternou'], 
    'apellido_materno'=>$_POST['apellido_maternou'],
    'fecha_nacimiento'=>$_POST['fecha_nacimientou'],
    'sexo'=>$_POST['sexou'],
    'telefono'=>$_POST['telefonou'],
    'correo'=>$_POST['correou'],
    'psicologo_encargado'=>$_POST['psicologo_encargadou']
);

include "../../clases/Usuarios.php";
$Usuarios= new Usuarios();
echo $Usuarios->actualizarPaciente($datos);
?>