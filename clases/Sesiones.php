<?php
include "Conexion.php";

class Sesiones extends Conexion{
    public function agregaNuevaSesion($datos){
        $conexion = Conexion::conectar();
        $idPaciente= $datos['id_paciente'];

        if($datos['cita'] == 1){ //busca y atiende citas dependiendo la sesion
            $sqlGetCitas="SELECT * FROM citas WHERE id_paciente = '$idPaciente' AND atendida = 0 AND eliminada = 0";
            $sqlGetCitasPaciente= "SELECT COUNT(id_cita) as totalCitas FROM citas where id_paciente = '$idPaciente' AND atendida = 0 AND eliminada = 0";
            $respuestaGetCitasPacientes = mysqli_query($conexion, $sqlGetCitasPaciente);
            $citasPacientesEncontradas = mysqli_fetch_assoc($respuestaGetCitasPacientes);

            if($citasPacientesEncontradas['totalCitas'] == 0){ //valida si puede quitar cita o no
                echo 'No hay citas pendientes de este paciente';
                die();
            }elseif($citasPacientesEncontradas['totalCitas'] > 0){
                $respuestaGetCitas = mysqli_query($conexion, $sqlGetCitas);
                while($getCitas = mysqli_fetch_array($respuestaGetCitas)){
                    $citasEncontradas = $getCitas['id_cita'];
                }
                $sqlUpdCita = "UPDATE citas set atendida = 1 WHERE id_cita = '$citasEncontradas'";
                $respuestaCierraCita = mysqli_query($conexion, $sqlUpdCita);
            }    
        }

        $sqlGetSesionesPaciente= "SELECT COUNT(id_paciente) as totalPaciente FROM sesiones where id_paciente = '$idPaciente'"; //validacion para quitar primera_vez
        $respuestaGetSesionesPaciente= mysqli_query($conexion, $sqlGetSesionesPaciente);
        $sesionesPaciente = mysqli_fetch_assoc($respuestaGetSesionesPaciente);

        if($sesionesPaciente['totalPaciente'] >= 1){
            $sqlUpdPrimeraVez ="UPDATE pacientes set primera_vez = 0 WHERE id_paciente = '$idPaciente'";
            $respuestaUpdPrimeraVez = mysqli_query($conexion, $sqlUpdPrimeraVez);
        }

        $sql="SELECT id_psicologo FROM pacientes where id_paciente = '$idPaciente'"; //busca el valor de id_psicologo en base al id_paciente
        $respuesta= mysqli_query($conexion, $sql);
        while($row=mysqli_fetch_array($respuesta)){
            $idPsicologo = $row['id_psicologo'];
        }

        $sql1="INSERT INTO sesiones (id_paciente, 
                                    id_psicologo, 
                                    tipo_sesion, 
                                    fecha_dia, 
                                    fecha_hora_inicio, 
                                    fecha_hora_fin,
                                    cita) VALUES (?,?,?,?,?,?,?)";
        $query= $conexion->prepare($sql1);
        $query->bind_param('iiisssi',   $datos['id_paciente'], $idPsicologo, $datos['tipo_sesion'],
                                        $datos['dia'], $datos['hora_inicio'], $datos['hora_fin'],
                                        $datos['cita']);
        $respuestaGeneral= $query->execute();
        $query->close();

        return $respuestaGeneral; 
    }
    
    public function eliminarSesion($idSesionEliminar){
        $conexion = Conexion::conectar();
        $sql="UPDATE sesiones set mostrar = 0 where id_sesion = '$idSesionEliminar'";
        $respuesta= mysqli_query($conexion, $sql);
        return $respuesta;
    }

    public function obtenerDatosSesionEditar($idSesionEditar){
        $conexion = Conexion::conectar();
        $sql = "SELECT 
                    id_sesion as idSesion,
                    id_paciente AS idPaciente,
                    tipo_sesion AS tipoSesion,
                    fecha_dia AS fechaDia,
                    fecha_hora_inicio AS horaInicio,
                    fecha_hora_fin AS horaFin,
                    cita
                FROM
                    sesiones where id_sesion='$idSesionEditar'";
        $respuesta= mysqli_query($conexion, $sql);
        $sesion = mysqli_fetch_array($respuesta);

        $datos= array(
            'idSesion' => $sesion['idSesion'],
            'idPaciente' => $sesion['idPaciente'],
            'tipoSesion' => $sesion['tipoSesion'],
            'fechaDia' => $sesion['fechaDia'],
            'horaInicio' => $sesion['horaInicio'],
            'horaFin' => $sesion['horaFin'],
            'cita' => $sesion['cita']
        );

        return $datos;
    }

    public function editarSesion($datos){
        $conexion= Conexion::conectar();
        $idSesionEditarU= $datos['idSesionEditar'];
        $idPacienteU = $datos['id_paciente'];
        
        if($datos['cita'] == 1){ //busca y atiende citas dependiendo la sesion
            $sqlGetCitas="SELECT * FROM citas WHERE id_paciente = '$idPacienteU' AND atendida = 0 AND eliminada = 0";
            $sqlGetCitasPaciente= "SELECT COUNT(id_cita) as totalCitas FROM citas where id_paciente = '$idPacienteU' AND atendida = 0 AND eliminada = 0";
            $respuestaGetCitasPacientes = mysqli_query($conexion, $sqlGetCitasPaciente);
            $citasPacientesEncontradas = mysqli_fetch_assoc($respuestaGetCitasPacientes);

            if($citasPacientesEncontradas['totalCitas'] == 0){ //valida si puede quitar cita o no
                echo 'No hay citas pendientes de este paciente';
                die();
            }elseif($citasPacientesEncontradas['totaCitas'] > 0){
                $respuestaGetCitas = mysqli_query($conexion, $sqlGetCitas);
                while($getCitas = mysqli_fetch_array($respuestaGetCitas)){
                    $citasEncontradas = $getCitas['id_cita'];
                }
                $sqlUpdCita = "UPDATE citas set atendida = 1 WHERE id_cita = '$citasEncontradas'";
                $respuestaCierraCita = mysqli_query($conexion, $sqlUpdCita);
            }    
        }

        $sqlGetSesionesPaciente= "SELECT COUNT(id_paciente) as totalPaciente FROM sesiones where id_paciente = '$idPacienteU'"; //validacion para quitar primera_vez
        $respuestaGetSesionesPaciente= mysqli_query($conexion, $sqlGetSesionesPaciente);
        $sesionesPaciente = mysqli_fetch_assoc($respuestaGetSesionesPaciente);

        if($sesionesPaciente['totalPaciente'] >= 1){
            $sqlUpdPrimeraVez ="UPDATE pacientes set primera_vez = 0 WHERE id_paciente = '$idPacienteU'";
            $respuestaUpdPrimeraVez = mysqli_query($conexion, $sqlUpdPrimeraVez);
        }

        $sql="UPDATE sesiones SET   tipo_sesion=?,
                                    fecha_dia=?,
                                    fecha_hora_inicio=?,
                                    fecha_hora_fin=?, 
                                    cita=?
                WHERE id_sesion= '$idSesionEditarU'";
        $query = $conexion->prepare($sql);
        $query-> bind_param('ssssi',    $datos['tipo_sesion'],$datos['dia'],$datos['hora_inicio'],
                                        $datos['hora_fin'],$datos['cita']);
        $respuesta = $query->execute();
        $query->close();
        
        return $respuesta;

    }
}
