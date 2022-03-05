<?php
include "plantilla.php";
include "../../clases/Conexion.php";
date_default_timezone_set("America/Monterrey");
$conexion = new Conexion();
$con = $conexion -> conectar();

$idPsicologo = $_GET['psiid'];
$sqlGetDatosPsi ="SELECT 
                    u.primer_nombre AS primerNombrePsi,
                    u.segundo_nombre AS segundoNombrePsi,
                    u.apellido_paterno AS paternoPsi,
                    u.apellido_materno AS maternoPsi,
                    pa.id_paciente,
                    pa.primer_nombre AS primerNombrePac,
                    pa.segundo_nombre AS segundoNombrePac,
                    pa.apellido_paterno AS paternoPac,
                    pa.apellido_materno AS maternoPac,
                    pa.fecha_nacimiento
                FROM
                    usuarios AS u
                        INNER JOIN
                    pacientes AS pa ON u.id_usuario = pa.id_psicologo
                WHERE id_usuario = '$idPsicologo'"; //tomo datos de paciente

$sqlGetDatosPac="SELECT 
                    pa.id_paciente as idPacienteData,
                    pa.primer_nombre AS primerNombrePac,
                    pa.segundo_nombre AS segundoNombrePac,
                    pa.apellido_paterno AS paternoPac,
                    pa.apellido_materno AS maternoPac,
                    pa.fecha_nacimiento,
                    u.primer_nombre as primerNombrePsi,
                    u.segundo_nombre as segundoNombrePsi,
                    u.apellido_paterno as paternoPsi, 
                    u.apellido_materno as maternoPsi
                FROM
                    pacientes AS pa
                        INNER JOIN
                    usuarios AS u ON pa.id_psicologo = u.id_usuario
                WHERE id_psicologo = '$idPsicologo' AND pa.id_estatus = 1 and pa.eliminado = 0";

$resultGetDatosPsi = mysqli_query($con, $sqlGetDatosPsi);
$resultGetDatosPac = mysqli_query($con, $sqlGetDatosPac);
$datosPsi = mysqli_fetch_assoc($resultGetDatosPsi);
$idPaciente = $datosPsi['id_paciente'];

//funcion para quitar espacios en nombre de psicologo
if($datosPsi['segundoNombrePsi'] == '' && $datosPsi['maternoPsi'] == ''){ 
    $nombrePsicologo = $datosPsi['primerNombrePsi']." ".$datosPsi['paternoPsi'];
    $nombrePsicologoReporte = $datosPsi['primerNombrePsi']."".$datosPsi['paternoPsi'];
}elseif($datosPsi['segundoNombrePsi'] == ''){
    $nombrePsicologo = $datosPsi['primerNombrePsi']." ".$datosPsi['paternoPsi'].' '.$datosPsi['maternoPsi'];
    $nombrePsicologoReporte = $datosPsi['primerNombrePsi']."".$datosPsi['paternoPsi'].''.$datosPsi['maternoPsi'];
}elseif($datosPsi['maternoPsi'] == ''){
    $nombrePsicologo = $datosPsi['primerNombrePsi']." ".$datosPsi['segundoNombrePsi']." ".$datosPsi['paternoPsi'];
    $nombrePsicologoReporte = $datosPsi['primerNombrePsi']."".$datosPsi['segundoNombrePsi']."".$datosPsi['paternoPsi'];
}else{
    $nombrePsicologo = $datosPsi['primerNombrePsi']." ".$datosPsi['segundoNombrePsi']." ".$datosPsi['paternoPsi'].' '.$datosPsi['maternoPsi'];
    $nombrePsicologoReporte = $datosPsi['primerNombrePsi']."".$datosPsi['segundoNombrePsi']."".$datosPsi['paternoPsi'].''.$datosPsi['maternoPsi'];
}

$pdf = new PDF('L', 'mm', 'letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', 'B',16);
$pdf->Cell(260,12,utf8_decode('Psicólogo: '.$nombrePsicologo),0,1, 'C');
$pdf->Ln(10);

//encabezado de la tabla
$pdf->Cell(17,12,'',0,0,'C');//fila vacia para centrar

$pdf->SetFillColor(64, 158, 230);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(80,12,utf8_decode('Paciente'),1,0,'C', 1);
$pdf->Cell(30,12,utf8_decode('Edad'),1,0,'C', 1);
$pdf->Cell(60,12,utf8_decode('Número de sesiones'),1,0,'C', 1);
$pdf->Cell(55,12,utf8_decode('Última sesión'),1,1,'C', 1);

while($datosPac = mysqli_fetch_array($resultGetDatosPac)){
    //funcion para quitar espacios en nombre de paciente
    if($datosPac['segundoNombrePac'] == '' && $datosPac['maternoPac'] == ''){ 
        $nombrePaciente = $datosPac['primerNombrePac']." ".$datosPac['paternoPac'];
        $nombrePacienteReporte = $datosPac['primerNombrePac']."".$datosPac['paternoPac'];
    }elseif($datosPac['segundoNombrePac'] == ''){
        $nombrePaciente = $datosPac['primerNombrePac']." ".$datosPac['paternoPac'].' '.$datosPac['maternoPac'];
        $nombrePacienteReporte = $datosPac['primerNombrePac']."".$datosPac['paternoPac'].''.$datosPac['maternoPac'];
    }elseif($datosPac['maternoPac'] == ''){
        $nombrePaciente = $datosPac['primerNombrePac']." ".$datosPac['segundoNombrePac']." ".$datosPac['paternoPac'];
        $nombrePacienteReporte = $datosPac['primerNombrePac']."".$datosPac['segundoNombrePac']."".$datosPac['paternoPac'];
    }else{
        $nombrePaciente = $datosPac['primerNombrePac']." ".$datosPac['segundoNombrePac']." ".$datosPac['paternoPac'].' '.$datosPac['maternoPac'];
        $nombrePacienteReporte = $datosPac['primerNombrePac']."".$datosPac['segundoNombrePac']."".$datosPac['paternoPac'].''.$datosPac['maternoPac'];
    }

    $idPacData= $datosPac['idPacienteData'];

    $fecha_nacimiento = $datosPac['fecha_nacimiento'];
    $fecha_actual = date("Y-m-d");
    $edad_diff = date_diff(date_create($fecha_nacimiento), date_create($fecha_actual));
    $edad = $edad_diff->format('%y');
    
    //busco cuantas sesiones tiene el paciente
    $sqlGetNumeroSesionesPac = "SELECT COUNT(id_sesion) as numeroSesiones FROM sesiones where id_paciente = '$idPacData' AND mostrar = 1";
    $resultadoGetNumeroSesionesPac = mysqli_query($con, $sqlGetNumeroSesionesPac);
    $totalSesiones = mysqli_fetch_assoc($resultadoGetNumeroSesionesPac);
    
    //busco la primer sesion que tuvo el paciente
    $sqlGetFirstSesion="SELECT fecha_dia AS primerSesion, fecha_hora_inicio, fecha_hora_fin FROM sesiones WHERE id_paciente = '$idPacData' AND mostrar = 1 ORDER BY fecha_dia LIMIT 1";
    $resultadoGetFirstSesion=mysqli_query($con, $sqlGetFirstSesion);
    $primerSesion = mysqli_fetch_assoc($resultadoGetFirstSesion);
    
    //busco la última sesion que tuvo el paciente
    $sqlGetLastSesion="SELECT fecha_dia AS ultimaSesion, fecha_hora_inicio, fecha_hora_fin FROM sesiones WHERE id_paciente = '$idPacData' AND mostrar = 1 ORDER BY fecha_dia DESC LIMIT 1";
    $resultadoGetLastSesion=mysqli_query($con, $sqlGetLastSesion);
    $ultimaSesion = mysqli_fetch_assoc($resultadoGetLastSesion);
    
    //cuerpo de la tabla
    $pdf->Cell(17,12,'',0,0,'C'); //fila vacia para centrar contenido
    
    $pdf->SetFont('Arial', '',14);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(80,12,utf8_decode($nombrePaciente),1,0,'C', 1);
    $pdf->Cell(30,12,utf8_decode($edad.' años'),1,0,'C', 1);
    $pdf->Cell(60,12,$totalSesiones['numeroSesiones'],1,0,'C', 1);
    $pdf->Cell(55,12,$ultimaSesion['ultimaSesion'],1,1,'C', 1);
}

$fecha_hoy = date('Y-m-d');
$hoy = date_create($fecha_hoy);
$mesInicio = date_format($hoy, "m");
$añoInicio = date_format($hoy, "Y");
$inicio_mes = $añoInicio."-".$mesInicio."-01";
$dia_semana = date('w');
$dia_actual = date('d');
$dia_inicio_semana = $dia_actual - $dia_semana;
$inicio_semana = $añoInicio."-".$mesInicio."-".$dia_inicio_semana;

$sqlGetTotalSesionesPsic = "SELECT COUNT(id_sesion) as totalSesiones FROM sesiones where id_psicologo = '$idPsicologo' and mostrar = 1";
$sqlGetTotalSesionesInd = "SELECT COUNT(id_sesion) as totalSesionesInd FROM sesiones where id_psicologo = '$idPsicologo' and mostrar = 1 and tipo_sesion= 1";
$sqlGetTotalSesionesPar = "SELECT COUNT(id_sesion) as totalSesionesPar FROM sesiones where id_psicologo = '$idPsicologo' and mostrar = 1 and tipo_sesion= 2";
$resultGetTotalSesionesPsic = mysqli_query($con, $sqlGetTotalSesionesPsic);
$resultGetTotalSesionesInd = mysqli_query($con, $sqlGetTotalSesionesInd);//cuento las sesiones individuales del psicologo
$resultGetTotalSesionesPar = mysqli_query($con, $sqlGetTotalSesionesPar);//cuento las sesiones en pareja del psicologo
$totalSesiones = mysqli_fetch_assoc($resultGetTotalSesionesPsic);
$totalSesionesInd = mysqli_fetch_assoc($resultGetTotalSesionesInd);
$totalSesionesPar = mysqli_fetch_assoc($resultGetTotalSesionesPar);
if($totalSesiones['totalSesiones'] == 1){ //determino si se escribe sesion o sesiones
    $palabraSesionSiempre = 'sesión';
}else{
    $palabraSesionSiempre = 'sesiones';
}


$sqlGetSesionesPsicMes = "SELECT COUNT(id_sesion) as sesionesMes from sesiones where id_psicologo = '$idPsicologo' and fecha_dia BETWEEN '$inicio_mes' and '$fecha_hoy' and mostrar = 1";
$sqlGetSesionesIndMes= "SELECT COUNT(tipo_sesion) as sesionInd from sesiones WHERE id_psicologo = '$idPsicologo' and fecha_dia BETWEEN '$inicio_mes' and '$fecha_hoy' and mostrar= 1 and tipo_sesion = 1";
$sqlGetSesionesParMes= "SELECT COUNT(tipo_sesion) as sesionPar from sesiones WHERE id_psicologo = '$idPsicologo' and fecha_dia BETWEEN '$inicio_mes' and '$fecha_hoy' and mostrar= 1 and tipo_sesion = 2";
$resultGetSesionesPsicMes = mysqli_query($con, $sqlGetSesionesPsicMes);
$resultGetTipoSesionesInd = mysqli_query($con, $sqlGetSesionesIndMes); //cuento las sesiones individuales del psicologo en el mes
$resultGetTipoSesionesPar = mysqli_query($con, $sqlGetSesionesParMes); //cuento las sesiones en pareja del psicologo en el mes
$sesionesMes = mysqli_fetch_assoc($resultGetSesionesPsicMes);
$sesionesIndMes = mysqli_fetch_assoc($resultGetTipoSesionesInd);
$sesionesParMes = mysqli_fetch_assoc($resultGetTipoSesionesPar);
if($sesionesMes['sesionesMes'] == 1){ //determino si se escribe sesion o sesiones
    $palabraSesionMes = 'sesión';
}else{
    $palabraSesionMes = 'sesiones';
}

$sqlGetSesionesPsicHoy = "SELECT COUNT(id_sesion) as sesionesHoy from sesiones where id_psicologo = '$idPsicologo' and fecha_dia = '$fecha_hoy' and mostrar = 1";
$sqlGetSesionesIndHoy = "SELECT COUNT(id_sesion) as sesionesIndHoy from sesiones where id_psicologo = '$idPsicologo' and fecha_dia = '$fecha_hoy' and mostrar = 1 and tipo_sesion = 1";
$sqlGetSesionesParHoy = "SELECT COUNT(id_sesion) as sesionesParHoy from sesiones where id_psicologo = '$idPsicologo' and fecha_dia = '$fecha_hoy' and mostrar = 1 and tipo_sesion = 2";
$resultGetSesionesPsicHoy = mysqli_query($con, $sqlGetSesionesPsicHoy);
$resultGetSesionesIndHoy=mysqli_query($con, $sqlGetSesionesIndHoy);//cuento las sesiones individuales del psicologo hoy
$resultGetSesionesParHoy=mysqli_query($con, $sqlGetSesionesParHoy);//cuento las sesiones en pareja del psicologo hoy
$sesionesHoy = mysqli_fetch_assoc($resultGetSesionesPsicHoy);
$sesionesIndHoy= mysqli_fetch_assoc($resultGetSesionesIndHoy);
$sesionesParHoy= mysqli_fetch_assoc($resultGetSesionesParHoy);
if($sesionesHoy['sesionesHoy'] == 1){ //determino si se escribe sesion o sesiones
    $palabraSesionHoy = 'sesión';
}else{
    $palabraSesionHoy = 'sesiones';
}

$sqlGetSesionesPsicSemana = "SELECT COUNT(id_sesion) as sesionesSemana from sesiones where id_psicologo = '$idPsicologo' and fecha_dia BETWEEN '$inicio_semana' and '$fecha_hoy' and mostrar = 1";
$sqlGetSesionesIndSemana = "SELECT COUNT(id_sesion) as sesionesIndSemana from sesiones where id_psicologo = '$idPsicologo' and fecha_dia BETWEEN '$inicio_semana' and '$fecha_hoy' and mostrar = 1 and tipo_sesion = 1";
$sqlGetSesionesParSemana = "SELECT COUNT(id_sesion) as sesionesParSemana from sesiones where id_psicologo = '$idPsicologo' and fecha_dia BETWEEN '$inicio_semana' and '$fecha_hoy' and mostrar = 1 and tipo_sesion = 2";
$resultGetSesionesPsicSemana = mysqli_query($con, $sqlGetSesionesPsicSemana);
$resultGetSesionesIndSemana = mysqli_query($con, $sqlGetSesionesIndSemana);//cuento las sesiones individuales del psicologo esta semana
$resultGetSesionesParSemana = mysqli_query($con, $sqlGetSesionesParSemana);//cuento las sesiones en pareja del psicologo esta semana
$sesionesSemana = mysqli_fetch_assoc($resultGetSesionesPsicSemana);
$sesionesIndSemana = mysqli_fetch_assoc($resultGetSesionesIndSemana);
$sesionesParSemana = mysqli_fetch_assoc($resultGetSesionesParSemana);
if($sesionesSemana['sesionesSemana'] == 1){ //determino si se escribe sesion o sesiones
    $palabraSesionSemana = 'sesión';
}else{
    $palabraSesionSemana = 'sesiones';
}

//datos adicionales

$pdf->SetFont('Arial', 'B', 14);
$pdf -> Cell(100,25,utf8_decode('NÚMEROS GENERALES DEL PSICÓLOGO '),0,1,'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(55,0,utf8_decode('Sesiones hoy: '),0,0,'L');//------------PRIMER TEXTO------------ 
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(55,0,utf8_decode($sesionesHoy['sesionesHoy'])." ".utf8_decode($palabraSesionHoy)." (Individual:".$sesionesIndHoy['sesionesIndHoy'].", Pareja: ".$sesionesParHoy['sesionesParHoy'].")",0,1,'L');//------------SEGUNDO TEXTO------------

$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(55,20,utf8_decode('Sesiones esta semana: '),0,0,'L');//------------PRIMER TEXTO------------ 
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(55,20,utf8_decode($sesionesSemana['sesionesSemana'])." ".utf8_decode($palabraSesionSemana)." (Individual:".$sesionesIndSemana['sesionesIndSemana'].", Pareja: ".$sesionesParSemana['sesionesParSemana'].")",0,1,'L');//------------SEGUNDO TEXTO------------

$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(55,0,utf8_decode('Sesiones este mes: '),0,0,'L');//------------PRIMER TEXTO------------ 
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(55,0,utf8_decode($sesionesMes['sesionesMes'])." ".utf8_decode($palabraSesionMes)." (Individual:".$sesionesIndMes['sesionInd'].", Pareja: ".$sesionesParMes['sesionPar'].")",0,1,'L');//------------SEGUNDO TEXTO------------

$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(55,20,utf8_decode('Sesiones siempre: '),0,0,'L');//------------PRIMER TEXTO------------
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(55,20,utf8_decode($totalSesiones['totalSesiones'])." ".utf8_decode($palabraSesionMes)." (Individual:".$totalSesionesInd['totalSesionesInd'].", Pareja: ".$totalSesionesPar['totalSesionesPar'].")",0,1,'L');//------------SEGUNDO TEXTO------------

$pdf->Output('I', utf8_decode('ReporteIndividual_'.$nombrePsicologoReporte.'.pdf')); //'D', 'Reporte-general.pdf'