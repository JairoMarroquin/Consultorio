<?php
    include "../../clases/Usuarios.php";
    $miCuenta = new Usuarios();

    if($_POST['usuarioEd'] == ''){
        $usuarioVacio = 1;
    }else{
        $usuarioVacio = 0;
    }
    if($_POST['contraseñaEd'] == ''){
        $contraVacia = 1;
    }else{
        $contraVacia = 0;
    }

    if($contraVacia == 0){ //si se puso contraseña se valida que cumpla los requisitos
        $numero = preg_match('@[0-9]@', $_POST['contraseñaEd']);
        if(!$numero || strlen($_POST['contraseñaEd']) < 8){
            echo 'La contraseña debe tener al menos 1 número y tener mínimo 8 caracteres.';
        }else{
            $datos = array(
                "id_usuario"=> $_POST['idCuentaEditar'],
                "primer_nombre"=> $_POST['primer_nombreEd'],
                "segundo_nombre"=> $_POST['segundo_nombreEd'],
                "apellido_paterno"=> $_POST['apellido_paternoEd'],
                "apellido_materno"=> $_POST['apellido_maternoEd'],
                "usuario"=> sha1($_POST['usuarioEd']),
                "contraseña"=> password_hash($_POST['contraseñaEd'], PASSWORD_DEFAULT),
                "usuarioVacio"=> $usuarioVacio,
                "contraVacia"=> $contraVacia
            );
        
            echo $miCuenta-> editarMiCuenta($datos);
        }
    }else{
        $datos = array(
            "id_usuario"=> $_POST['idCuentaEditar'],
            "primer_nombre"=> $_POST['primer_nombreEd'],
            "segundo_nombre"=> $_POST['segundo_nombreEd'],
            "apellido_paterno"=> $_POST['apellido_paternoEd'],
            "apellido_materno"=> $_POST['apellido_maternoEd'],
            "usuario"=> sha1($_POST['usuarioEd']),
            "contraseña"=> password_hash($_POST['contraseñaEd'], PASSWORD_DEFAULT),
            "usuarioVacio"=> $usuarioVacio,
            "contraVacia"=> $contraVacia,
        );
    
        echo $miCuenta-> editarMiCuenta($datos);
    }
?>