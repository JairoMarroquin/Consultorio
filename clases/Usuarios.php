<?php
include "Conexion.php";

    class Usuarios extends Conexion {

        public function loginUsuario($usuario, $password, $contraPlana){
            $conexion = Conexion::conectar();
            $sqlValidaFechaVencimiento="SELECT * FROM contrato";
            $respuestaValidaFechaVencimiento = mysqli_query($conexion, $sqlValidaFechaVencimiento);
            $fecha_vencimiento = mysqli_fetch_assoc($respuestaValidaFechaVencimiento);
            date_default_timezone_set("America/Mexico_City");
            $fecha_actual = date("Y-m-d");

            if($fecha_vencimiento['fecha_vencimiento'] > $fecha_actual || $fecha_vencimiento['fecha_vencimiento'] =="-1"){
                $sqlUsuario = "SELECT * from usuarios where usuario= '$usuario'";
                $respuestaUsuario= mysqli_query($conexion, $sqlUsuario);
    
                if(mysqli_num_rows($respuestaUsuario) > 0){ //revisa si existe el usuario
                    while(mysqli_fetch_array($respuestaUsuario)){ //ejecuta la validacion hasta que se acaben los usuarios repetidos
                        $sqlValida= "SELECT * FROM usuarios WHERE usuario = '$usuario'";
                        $respuestaContraseña= mysqli_query($conexion, $sqlValida);
                        
                        while($row= mysqli_fetch_array($respuestaContraseña)){
                            if($row['bit_activo'] == 1){
                                if(password_verify($contraPlana, $row['contraseña'])){ //comprueba que la contraseña del usuario sea la correcta
                                    if(mysqli_num_rows($respuestaContraseña)>0){
                                        $_SESSION['usuario']['nombre'] = $row['primer_nombre'];
                                        $_SESSION['usuario']['segundo_nombre'] = $row['segundo_nombre']; //toma los datos de la columna primer_nombre y las guarda en $_SESSION['usuario']['nombre']
                                        $_SESSION['usuario']['id'] = $row['id_usuario'];
                                        $_SESSION['usuario']['rol'] = $row['id_rol'];
                                        $_SESSION['usuario']['apellido'] = $row['apellido_paterno'];
                                        $_SESSION['usuario']['apellido_materno'] = $row['apellido_materno'];
                                        return 1;
                                    }
                                }else {
                                    echo 'El usuario y/o contraseña no es válida (CNV)';
                                }
                            }else{
                                echo 'El usuario esta deshabilitado. Contacte con el administrador.';
                            }               
                        }
                    }
                    
                }else{
                    echo 'El usuario y/o contraseña no es válida (UNV)';
                }
            }else{
                echo 'Sistema vencido. En caso de que desee renovar contactar al proveedor.';  
            }          
        }

        public function agregaNuevoPaciente($datos){
            $conexion = Conexion::conectar();
            date_default_timezone_set("America/Mexico_City");
            $nacimiento = $datos['fecha_nacimiento'];
            $fecha_Actual = date("Y-m-d");

            if($nacimiento >= $fecha_Actual){
                echo "Fecha de nacimiento inválida.";
            }else{
                $sql="INSERT INTO pacientes (
                                    primer_nombre, 
                                    segundo_nombre, 
                                    apellido_paterno, 
                                    apellido_materno, 
                                    fecha_nacimiento, 
                                    sexo, 
                                    telefono, 
                                    correo, 
                                    id_psicologo) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $query = $conexion->prepare($sql);
                $query->bind_param("ssssssssi", $datos['primer_nombre'],$datos['segundo_nombre'],$datos['apellido_paterno'],
                                        $datos['apellido_materno'],$datos['fecha_nacimiento'],$datos['sexo'],
                                        $datos['telefono'],$datos['correo'],$datos['id_psicologo']);
                $respuesta= $query->execute();
                $idPaciente = mysqli_insert_id($conexion);
                $query->close();
                return $respuesta;
            }
            
        }

        public function editarPrimeraVez($idPaciente){
            $conexion = Conexion::conectar();
            $sql = "UPDATE pacientes set primera_vez = 2 where id_paciente = '$idPaciente'";
            $respuesta= mysqli_query($conexion, $sql);
            return $respuesta;
        }

        public function eliminarPaciente($idPacienteEliminar){
            $conexion = Conexion::conectar();
            $sql= "UPDATE pacientes set eliminado = 1 WHERE id_paciente= '$idPacienteEliminar'";
            $respuesta= mysqli_query($conexion, $sql);
            return $respuesta;
        }

        public function agregarUsuario($datos){
            $user = $datos['usuario'];
            $fecha = date("Y-m-d");
            $conexion = Conexion::conectar();
            $sqlValidaUsuario= "SELECT usuario from usuarios where usuario = '$user'";
            $respuestaValidaUsuario= mysqli_query($conexion, $sqlValidaUsuario);
            
            if(mysqli_num_rows($respuestaValidaUsuario) == 1){
                    echo 'Ese usuario ya existe, intenta con uno diferente.';
            }elseif(mysqli_num_rows($respuestaValidaUsuario) == 0){
                $sql ="INSERT INTO usuarios (primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, fecha_alta, usuario, contraseña, bit_psicologo, id_rol)
                values (?,?,?,?,?,?,?,?,?)";
                $query= $conexion->prepare($sql);
                $query-> bind_param('sssssssii',   $datos['primer_nombre'],$datos['segundo_nombre'],$datos['apellido_paterno'],
                                                            $datos['apellido_materno'], $fecha, $datos['usuario'],$datos['contraseña'],
                                                            $datos['bit_psicologo'],$datos['id_rol']);
                $respuesta= $query->execute();
                $query->close();
                return $respuesta;
            }   
        }

        public function desactivarUsuario($idUsuarioDesactivar){
            $conexion = Conexion::conectar();
            $sql= "UPDATE usuarios set bit_activo = 0 where id_usuario= '$idUsuarioDesactivar'";
            $respuesta = mysqli_query($conexion, $sql);
            return $respuesta;
        }

        public function activarUsuario($idUsuarioActivar){
            $conexion = Conexion::conectar();
            $sql= "UPDATE usuarios set bit_activo = 1 where id_usuario= '$idUsuarioActivar'";
            $respuesta = mysqli_query($conexion, $sql);
            return $respuesta;
        }

        public function obtenerDatosPacienteEditar($idPacienteEditar){
            $conexion = Conexion::conectar();
            $sql="select
                    usuarios.id_usuario as idPsicologo, 
                    usuarios.primer_nombre as nombrePsicologo, 
                    usuarios.apellido_paterno as apellidoPsicologo, 
                    pacientes.id_psicologo as idPsicologoPaciente,
                    pacientes.id_paciente as idPaciente, 
                    pacientes.primer_nombre as nombrePaciente, 
                    pacientes.segundo_nombre as segundoNombre, 
                    pacientes.apellido_paterno as apellidoPaternoPaciente, 
                    pacientes.apellido_materno as apellidoMaternoPaciente,
                    pacientes.id_estatus as estatusPaciente, 
                    pacientes.fecha_nacimiento as fechaNacimiento,
                    pacientes.primera_vez as primeraVez, 
                    pacientes.sexo, 
                    pacientes.telefono, 
                    pacientes.correo,
                    pacientes.eliminado
                from pacientes as pacientes 
                    inner join 
                usuarios as usuarios on pacientes.id_psicologo = usuarios.id_usuario
                    AND id_paciente = '$idPacienteEditar'";
            
            $respuesta= mysqli_query($conexion, $sql);
            $paciente = mysqli_fetch_array($respuesta);

            $datos = array(
                'idPsicologo'=>$paciente['idPsicologo'], 
                'nombrePsicologo'=>$paciente['nombrePsicologo'], 
                'apellidoPsicologo'=>$paciente['apellidoPsicologo'], 
                'idPsicologoPaciente'=>$paciente['idPsicologoPaciente'],
                'idPaciente'=>$paciente['idPaciente'], 
                'nombrePaciente'=>$paciente['nombrePaciente'], 
                'segundoNombre'=>$paciente['segundoNombre'], 
                'apellidoPaternoPaciente'=>$paciente['apellidoPaternoPaciente'], 
                'apellidoMaternoPaciente'=>$paciente['apellidoMaternoPaciente'],
                'estatusPaciente'=>$paciente['estatusPaciente'], 
                'fechaNacimiento'=>$paciente['fechaNacimiento'],
                'primeraVez'=>$paciente['primeraVez'], 
                'sexo'=>$paciente['sexo'], 
                'telefono'=>$paciente['telefono'], 
                'correo'=>$paciente['correo'],
                'eliminado'=>$paciente['eliminado']
            );

            return $datos;
        }

        public function actualizarPaciente($datos){
            $conexion = Conexion::conectar();
            $idPacienteU= $datos['idPacienteEditar'];
            date_default_timezone_set("America/Mexico_City");
            $nacimiento = $datos['fecha_nacimiento'];
            $fecha_Actual = date("Y-m-d");

            if($nacimiento >= $fecha_Actual){
                echo "Fecha de nacimiento inválida.";
            }else{
                $sql="UPDATE pacientes set  primer_nombre=?, 
                                            segundo_nombre=?, 
                                            apellido_paterno=?, 
                                            apellido_materno=?, 
                                            fecha_nacimiento=?, 
                                            sexo=?, 
                                            telefono=?, 
                                            correo=?, 
                                            id_psicologo=?
                WHERE id_paciente = '$idPacienteU'";
                $query = $conexion->prepare($sql);
                $query->bind_param('ssssssssi', $datos['primer_nombre'],$datos['segundo_nombre'],$datos['apellido_paterno'],
                                $datos['apellido_materno'],$datos['fecha_nacimiento'],$datos['sexo'],
                                $datos['telefono'],$datos['correo'],$datos['psicologo_encargado']);

                $respuesta= $query->execute();
                $query -> close();
                return $respuesta;
            }
        }
        
        public function obtenerDatosUsuarioEditar($idUsuarioEditar){
            $conexion = Conexion::conectar();
            $sql="SELECT 
                    usuarios.id_usuario as idUsuario,
                    usuarios.primer_nombre as primerNombre,
                    usuarios.segundo_nombre as segundoNombre,
                    usuarios.apellido_paterno as apellidoPaterno,
                    usuarios.apellido_materno as apellidoMaterno,
                    usuarios.bit_psicologo as psicologo,
                    usuarios.fecha_alta as fechaAlta,
                    usuarios.bit_activo as activo,
                    usuarios.id_rol as usuarioRol,
                    usuarios.usuario as usuario,
                    usuarios.contraseña as contraseña,
                    rol.id_rol  as rolRol,
                    rol.nombre as rolNombre
                FROM
                    usuarios AS usuarios
                        INNER JOIN
                    rol AS rol ON usuarios.id_rol = rol.id_rol
                AND id_usuario = '$idUsuarioEditar'
                    ORDER BY usuarios.id_usuario";
                
            $respuesta= mysqli_query($conexion, $sql);
            $usuario = mysqli_fetch_array($respuesta);

            $datos = array(
                'idUsuarioEditar'=>$usuario['idUsuario'], 
                'primerNombre'=>$usuario['primerNombre'], 
                'segundoNombre'=>$usuario['segundoNombre'], 
                'apellidoPaterno'=>$usuario['apellidoPaterno'], 
                'apellidoMaterno'=>$usuario['apellidoMaterno'],
                'psicologo'=>$usuario['psicologo'],
                'usuarioRol'=>$usuario['usuarioRol']);

            return $datos;
        }

        public function editarUsuario($datos){

            $user = $datos['usuario'];
            $conexion = Conexion::conectar();
            $idUsuarioU = $datos['idUsuarioEditar'];

            if($datos['validaUsuario'] == 1 && $datos['validaContra'] == 0){ //valida si usuario esta vacios o no
                $sql="UPDATE usuarios SET   primer_nombre =?,
                                            segundo_nombre =?,
                                            apellido_paterno =?,
                                            apellido_materno =?,
                                            contraseña =?,
                                            bit_psicologo =?,
                                            id_rol =?
                    WHERE id_usuario = '$idUsuarioU'";
                $query= $conexion-> prepare($sql);
                $query->bind_param('sssssii',  $datos['primerNombre'],$datos['segundoNombre'],$datos['apellidoPaterno'],
                                                $datos['apellidoMaterno'],$datos['contraseña'],
                                                $datos['psicologo'],$datos['usuarioRol']);

                $respuesta= $query ->execute();
                $query -> close();
                return $respuesta;
                
            }elseif($datos['validaContra'] == 1 && $datos['validaUsuario'] == 0){ //valida si contraseña esta vacio
                $sqlValidaUsuario= "SELECT usuario from usuarios where usuario = '$user'";
                $respuestaValidaUsuario= mysqli_query($conexion, $sqlValidaUsuario);

                if(mysqli_num_rows($respuestaValidaUsuario) == 1){
                    echo 'Ese usuario ya existe, intenta con uno diferente.';
                }elseif(mysqli_num_rows($respuestaValidaUsuario) == 0){
                    $sql="UPDATE usuarios SET   primer_nombre =?,
                                                segundo_nombre =?,
                                                apellido_paterno =?,
                                                apellido_materno =?,
                                                usuario =?,
                                                bit_psicologo =?,
                                                id_rol =?
                        WHERE id_usuario = '$idUsuarioU'";
                    $query= $conexion-> prepare($sql);
                    $query->bind_param('sssssii',  $datos['primerNombre'],$datos['segundoNombre'],$datos['apellidoPaterno'],
                                                    $datos['apellidoMaterno'],$datos['usuario'],
                                                    $datos['psicologo'],$datos['usuarioRol']);

                    $respuesta= $query ->execute();
                    $query -> close();
                    return $respuesta;
                }
            }elseif($datos['validaUsuario'] == 1 && $datos['validaContra'] == 1){//valida si no se agrego usuario ni contraseña   
                $sql="UPDATE usuarios SET   primer_nombre =?,
                                            segundo_nombre =?,
                                            apellido_paterno =?,
                                            apellido_materno =?,
                                            bit_psicologo =?,
                                            id_rol =?
                    WHERE id_usuario = '$idUsuarioU'";
                $query= $conexion-> prepare($sql);
                $query->bind_param('ssssii',  $datos['primerNombre'],$datos['segundoNombre'],$datos['apellidoPaterno'],
                                                $datos['apellidoMaterno'],
                                                $datos['psicologo'],$datos['usuarioRol']);

                $respuesta= $query ->execute();
                $query -> close();
                return $respuesta;
            }elseif($datos['validaUsuario'] == 0 && $datos['validaContra'] == 0){ //si se ingreso usuario y contraseña es el query original
                $sqlValidaUsuario= "SELECT usuario from usuarios where usuario = '$user'";
                $respuestaValidaUsuario= mysqli_query($conexion, $sqlValidaUsuario);

                if(mysqli_num_rows($respuestaValidaUsuario) == 1){
                    echo 'Ese usuario ya existe, intenta con uno diferente.';
                }elseif(mysqli_num_rows($respuestaValidaUsuario) == 0){
                    $sql="UPDATE usuarios SET   primer_nombre =?,
                                                segundo_nombre =?,
                                                apellido_paterno =?,
                                                apellido_materno =?,
                                                usuario =?,
                                                contraseña =?,
                                                bit_psicologo =?,
                                                id_rol =?
                        WHERE id_usuario = '$idUsuarioU'";
                    $query= $conexion-> prepare($sql);
                    $query->bind_param('ssssssii',  $datos['primerNombre'],$datos['segundoNombre'],$datos['apellidoPaterno'],
                                                    $datos['apellidoMaterno'],$datos['usuario'],$datos['contraseña'],
                                                    $datos['psicologo'],$datos['usuarioRol']);

                    $respuesta= $query ->execute();
                    $query -> close();
                    return $respuesta;
                }
            }else{
                echo 'Error general.';
            }
        }

        public function editarMiCuenta($datos){
            $idUsuarioEditar= $datos['id_usuario'];
            $user= $datos['usuario'];
            $conexion = Conexion::conectar();

            if($datos['usuarioVacio'] == 1 && $datos['contraVacia'] == 0){ //usuario vacio
                $sql="UPDATE usuarios SET   primer_nombre =?,
                                            segundo_nombre =?,
                                            apellido_paterno =?,
                                            apellido_materno =?,
                                            contraseña =?
                    WHERE id_usuario = '$idUsuarioEditar'";

                    $query= $conexion-> prepare($sql);
                    $query->bind_param('sssss',  $datos['primer_nombre'],$datos['segundo_nombre'],$datos['apellido_paterno'],
                                        $datos['apellido_materno'],$datos['contraseña']);

                    $respuesta= $query ->execute();
                    $query -> close();
                    return $respuesta;
            }elseif($datos['usuarioVacio'] == 0 && $datos['contraVacia'] == 1){ //contraseña vacia
                $sqlValidaUsuario= "SELECT usuario from usuarios where usuario = '$user'";
                $respuestaValidaUsuario= mysqli_query($conexion, $sqlValidaUsuario);

                if(mysqli_num_rows($respuestaValidaUsuario) == 1){
                    echo 'Ese usuario ya existe, intenta con uno diferente.';
                }elseif(mysqli_num_rows($respuestaValidaUsuario) == 0){
                    $sql="UPDATE usuarios SET   primer_nombre =?,
                                                segundo_nombre =?,
                                                apellido_paterno =?,
                                                apellido_materno =?,
                                                usuario =?
                        WHERE id_usuario = '$idUsuarioEditar'";
                    $query= $conexion-> prepare($sql);
                    $query->bind_param('sssss',  $datos['primer_nombre'],$datos['segundo_nombre'],$datos['apellido_paterno'],
                                                    $datos['apellido_materno'],$datos['usuario']);

                    $respuesta= $query ->execute();
                    $query -> close();
                    return $respuesta;
                }
            }elseif($datos['usuarioVacio'] == 0 && $datos['contraVacia'] == 0){ //nada vacio
                $sqlValidaUsuario= "SELECT usuario from usuarios where usuario = '$user'";
                $respuestaValidaUsuario= mysqli_query($conexion, $sqlValidaUsuario);

                if(mysqli_num_rows($respuestaValidaUsuario) == 1){
                    echo 'Ese usuario ya existe, intenta con uno diferente.';
                }elseif(mysqli_num_rows($respuestaValidaUsuario) == 0){
                    $sql="UPDATE usuarios SET   primer_nombre =?,
                                                segundo_nombre =?,
                                                apellido_paterno =?,
                                                apellido_materno =?,
                                                usuario =?,
                                                contraseña =?
                        WHERE id_usuario = '$idUsuarioEditar'";
                    $query= $conexion-> prepare($sql);
                    $query->bind_param('ssssss',  $datos['primer_nombre'],$datos['segundo_nombre'],$datos['apellido_paterno'],
                                                    $datos['apellido_materno'],$datos['usuario'],$datos['contraseña']);

                    $respuesta= $query ->execute();
                    $query -> close();
                    return $respuesta;
                }
            }elseif($datos['usuarioVacio'] == 1 && $datos['contraVacia'] == 1){ //usuario y contraseña vacios
                $sql="UPDATE usuarios SET   primer_nombre =?,
                                            segundo_nombre =?,
                                            apellido_paterno =?,
                                            apellido_materno =?
                            WHERE id_usuario = '$idUsuarioEditar'";
                            $query= $conexion-> prepare($sql);
                            $query->bind_param('ssss',  $datos['primer_nombre'],$datos['segundo_nombre'],$datos['apellido_paterno'],
                                                $datos['apellido_materno']);

                            $respuesta= $query ->execute();
                            $query -> close();
                            return $respuesta;
            }else{
                echo 'No se pudo guardar al usuario.';
            }
        }
    }
?>