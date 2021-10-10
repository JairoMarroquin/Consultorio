<?php

include "../../../clases/Usuarios.php";

//valida seguridad de la contraseña
$numero = preg_match('@[0-9]@', $_POST['contraseña']);

if(!$numero || strlen($_POST['contraseña']) < 8){
    echo 'La contraseña debe tener al menos 1 número y tener mínimo 8 caracteres.';
}else{
    $datos= array(
        "primer_nombre" => $_POST['primer_nombre'],
        "segundo_nombre" => $_POST['segundo_nombre'],
        "apellido_paterno" => $_POST['apellido_paterno'],
        "apellido_materno" => $_POST['apellido_materno'],
        "usuario"=> sha1($_POST['usuario']),
        "contraseña"=> password_hash($_POST['contraseña'], PASSWORD_DEFAULT),
        "bit_psicologo"=> $_POST['esPsicologo'],
        "id_rol"=>$_POST['rol']
    );
    $Usuarios = new Usuarios();

    echo $Usuarios->agregarUsuario($datos);
}
?>