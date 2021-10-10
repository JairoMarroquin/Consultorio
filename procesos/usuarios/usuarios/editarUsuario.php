<?php

include "../../../clases/Usuarios.php";

if($_POST['usuariou'] == ''){
    $usuarioVacio= 1;
}else{
    $usuarioVacio= 0;
}

if($_POST['contraseñau'] == ''){
    $contraseñaVacia= 1;
}else{
    $contraseñaVacia= 0;
}

if($contraseñaVacia == 0){ //si se puso contraseña se valida que cumpla los requisitos
    $numero = preg_match('@[0-9]@', $_POST['contraseñau']);
    if(!$numero || strlen($_POST['contraseñau']) < 8){
        echo 'La contraseña debe tener al menos 1 número y tener mínimo 8 caracteres.';
    }else{
        $datos = array(
            'idUsuarioEditar'=>$_POST['idUsuarioEditar'], 
            'primerNombre'=>$_POST['primer_nombreu'], 
            'segundoNombre'=>$_POST['segundo_nombreu'], 
            'apellidoPaterno'=>$_POST['apellido_paternou'], 
            'apellidoMaterno'=>$_POST['apellido_maternou'],
            'usuario'=>sha1($_POST['usuariou']),
            'contraseña'=>password_hash($_POST['contraseñau'], PASSWORD_DEFAULT),
            'psicologo'=>$_POST['esPsicologou'],
            'usuarioRol'=>$_POST['rolCu'],
            'validaUsuario'=> $usuarioVacio,
            'validaContra'=> $contraseñaVacia
        );

        $Usuarios = new Usuarios();
    
        echo $Usuarios->editarUsuario($datos);
    }
}else{
    $datos = array(
        'idUsuarioEditar'=>$_POST['idUsuarioEditar'], 
        'primerNombre'=>$_POST['primer_nombreu'], 
        'segundoNombre'=>$_POST['segundo_nombreu'], 
        'apellidoPaterno'=>$_POST['apellido_paternou'], 
        'apellidoMaterno'=>$_POST['apellido_maternou'],
        'usuario'=>sha1($_POST['usuariou']),
        'contraseña'=>password_hash($_POST['contraseñau'], PASSWORD_DEFAULT),
        'psicologo'=>$_POST['esPsicologou'],
        'usuarioRol'=>$_POST['rolCu'],
        'validaUsuario'=> $usuarioVacio,
        'validaContra'=> $contraseñaVacia
    );

    $Usuarios = new Usuarios();

    echo $Usuarios->editarUsuario($datos);
}
?>