<?php
include "Conexion.php";

class Citas extends Conexion{
    public function eliminarCita($idCitaEliminar){
        $conexion = Conexion::conectar();
        $sql="UPDATE citas set eliminada = 1 where id_cita = '$idCitaEliminar'";
        $respuesta= mysqli_query($conexion, $sql);
        return $respuesta;
    }

    public function agregarCita($datos){
        $conexion = Conexion::conectar();
        $idPaciente= $datos['id_paciente'];

        $queryGetCitas="SELECT COUNT(id_cita) as numeroCitas FROM citas where id_paciente = '$idPaciente' and atendida = 0 and eliminada = 0";
        $respuestaGetCitas = mysqli_query($conexion, $queryGetCitas);
        $numeroCitas = mysqli_fetch_assoc($respuestaGetCitas);
        
        if($numeroCitas['numeroCitas'] > 0 ){
            echo 'Este paciente ya tiene una cita pendiente.';
        }else{
            $sql="SELECT id_psicologo FROM pacientes where id_paciente = '$idPaciente'"; //busca el valor de id_psicologo en base al id_paciente
            $respuesta= mysqli_query($conexion, $sql);
    
            while($row=mysqli_fetch_array($respuesta)){
                $idPsicologo = $row['id_psicologo'];
            }
            $sql1= "INSERT INTO citas   (id_paciente,
                                        id_psicologo, 
                                        tipo_sesion,
                                        fecha_dia,
                                        fecha_hora,
                                        notas) VALUES(?,?,?,?,?,?)";
            $query = $conexion->prepare($sql1);
            $query->bind_param('iiisss', $datos['id_paciente'], $idPsicologo, $datos['tipo_sesion'], $datos['dia'], $datos['hora_cita'], $datos['notas']);
            $respuesta1= $query->execute();
            $query->close();
            return $respuesta1;
        }
    }

    public function obtenerDatosCitasEditar($idCitaEditar){
        $conexion = Conexion::conectar();
        $sql = "SELECT * FROM citas WHERE id_cita = '$idCitaEditar'";
        $respuesta = mysqli_query($conexion, $sql);
        $cita = mysqli_fetch_array($respuesta);

        $datos = array(
            'idCita' => $cita['id_cita'],
            'idPaciente' => $cita['id_paciente'],
            'idPsicologo' => $cita['id_psicologo'],
            'tipoSesion' => $cita['tipo_sesion'],
            'fechaDia' => $cita['fecha_dia'],
            'fechaHora' => $cita['fecha_hora'],
            'notas' => $cita['notas']
        );

        return $datos;
    }

    public function editarCita($datos){
        $conexion = Conexion::conectar();
        $idCitaEditarU = $datos['idCitaEditar'];
        $sql = "UPDATE citas SET id_paciente = ?, tipo_sesion = ?, fecha_dia = ?, fecha_hora = ?, notas = ? WHERE id_cita = '$idCitaEditarU'";
        $query = $conexion -> prepare($sql);
        $query -> bind_param('iisss',    $datos['id_paciente'],$datos['tipo_sesion'],$datos['fecha_dia'],
                                        $datos['fecha_hora'],$datos['notas']);

        $respuesta = $query->execute();
        $query->close();

        return $respuesta;
    }
}
?>