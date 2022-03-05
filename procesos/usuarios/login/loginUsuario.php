<?php
session_start();
//-----PASSWORD_HASH-----
include "../../../clases/Usuarios.php";
$usuario= sha1($_POST['usuario']);
$contraPlana= $_POST['password'];
$password= password_hash($_POST['password'], PASSWORD_DEFAULT);

$Usuarios = new Usuarios();
echo $Usuarios -> loginUsuario($usuario, $contraPlana);


?>