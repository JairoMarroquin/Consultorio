<?php
ini_set('default_charset', 'windows-1252');
include "../../clases/Conexion.php";
$fecha_inicial=$_POST['dia_inicial'];
$fecha_final=$_POST['dia_final'];
$con= new Conexion();
$conexion = $con->conectar();

if(isset($_POST['generar_reporte'])){
    header('Content-Type:text/csv; charset=ISO-8859');
    header('Content-Disposition: attachment; filename="Reporte_Simple_Sesiones.csv"');

    $salida=fopen('php://output', 'w');
    fputcsv($salida, array( utf8_decode('Numero de Sesión'), 'Primer Nombre del paciente','Segundo Nombre del Paciente','Apellido Paterno del Paciente',
                            'Apellido Materno del Paciente', utf8_decode('Primer Nombre del Psicólogo'),utf8_decode('Segundo Nombre del Psicólogo'),utf8_decode('Apellido Paterno del Psicólogo'),utf8_decode('Apellido Materno del Psicológo'), 
                            utf8_decode('Tipo de Sesión'), utf8_decode('Día'), 'Horario', utf8_decode('Sesión con cita previa')));

    $sql="SELECT 
            sesiones.id_sesion AS idSesion,
            sesiones.id_paciente AS idPaciente,
            sesiones.id_psicologo AS idPsicologo,
            sesiones.tipo_sesion AS tipoSesion,
            sesiones.fecha_dia as fechaDia,
            sesiones.fecha_hora_inicio as fechaHoraInicio,
            sesiones.fecha_hora_fin as fechaHoraFin,
            sesiones.cita,
            sesiones.mostrar,
            tipoSesion.id_TipoSesion as idTipoSesion,
            tipoSesion.nombre as sesionNombre,
            pacientes.id_paciente as idPaciente,
            pacientes.primer_nombre as nombrePaciente,
            pacientes.segundo_nombre as segundoNombrePaciente,
            pacientes.apellido_paterno as apellidoPaciente,
            pacientes.apellido_materno as apellidoMaternoPaciente,
            usuarios.id_usuario as idPsicologo,
            usuarios.primer_nombre as nombrePsicologo,
            usuarios.segundo_nombre as segundoNombrePsicologo,
            usuarios.apellido_paterno as apellidoPsicologo,
            usuarios.apellido_materno as apellidoMaternoPsicologo
        FROM
            sesiones AS sesiones
                INNER JOIN
            tipo_sesion AS tipoSesion ON sesiones.tipo_sesion = tipoSesion.id_tipoSesion
                inner join
            pacientes as pacientes ON sesiones.id_paciente =  pacientes.id_paciente
                inner join
            usuarios as usuarios ON sesiones.id_psicologo = usuarios.id_usuario
        WHERE fecha_dia BETWEEN '$fecha_inicial' and '$fecha_final'
        ORDER BY id_sesion";

    $respuesta = mysqli_query($conexion, $sql);

    while($reporte= mysqli_fetch_array($respuesta)){
        if($reporte['cita'] == 1){
            $cita= 'Si';
        }else{
            $cita = 'No';
        }
        fputcsv($salida, array( $reporte['idSesion'],utf8_decode($reporte['nombrePaciente']),utf8_decode($reporte['segundoNombrePaciente']),
                                utf8_decode($reporte['apellidoPaciente']),utf8_decode($reporte['apellidoMaternoPaciente']),utf8_decode($reporte['nombrePsicologo']),
                                utf8_decode($reporte['segundoNombrePsicologo']),utf8_decode($reporte['apellidoPsicologo']),utf8_decode($reporte['apellidoMaternoPsicologo']),
                                $reporte['sesionNombre'],$reporte['fechaHoraInicio'],$reporte['fechaHoraFin'],
                                $cita));
    }
}
?>