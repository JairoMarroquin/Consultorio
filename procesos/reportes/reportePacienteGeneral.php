<?php
include "plantilla.php";
include "../../clases/Conexion.php";
date_default_timezone_set("America/Monterrey");
$conexion = new Conexion();
$con = $conexion -> conectar();

$idPaciente = $_GET['pacid'];
$sqlGetDatosPac ="SELECT 
                    pac.id_paciente,
                    pac.id_psicologo AS idPsicologoPaciente,
                    pac.primer_nombre AS primerNombrePac,
                    pac.segundo_nombre AS segundoNombrePac,
                    pac.apellido_paterno AS paternoPac,
                    pac.apellido_materno AS maternoPac,
                    pac.id_estatus AS estatusPac,
                    pac.fecha_nacimiento AS nacimientoPac,
                    pac.primera_vez,
                    pac.sexo,
                    pac.telefono,
                    pac.correo,
                    pac.fecha_nacimiento,
                    psi.primer_nombre AS primerNombrePsic,
                    psi.segundo_nombre AS segundoNombrePsi,
                    psi.apellido_paterno AS paternoPsi,
                    psi.apellido_materno AS maternoPsi,
                    e.descripcion
                FROM
                    pacientes AS pac
                        INNER JOIN
                    usuarios AS psi ON pac.id_psicologo = psi.id_usuario
                        INNER JOIN
                    estatus_paciente AS e ON pac.id_estatus = e.id_estatus
                WHERE id_paciente = '$idPaciente'"; //tomo datos de paciente

$resultGetDatosPac = mysqli_query($con, $sqlGetDatosPac);
$datosPac = mysqli_fetch_assoc($resultGetDatosPac);

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

//funcion para quitar espacios en nombre de psicologo
if($datosPac['segundoNombrePsi'] == '' && $datosPac['maternoPac'] == ''){ 
    $nombrePsicologo = $datosPac['primerNombrePsic']." ".$datosPac['paternoPsi'];
}elseif($datosPac['segundoNombrePsi'] == ''){
    $nombrePsicologo = $datosPac['primerNombrePsic']." ".$datosPac['paternoPsi'].' '.$datosPac['maternoPac'];
}elseif($datosPac['maternoPac'] == ''){
    $nombrePsicologo = $datosPac['primerNombrePsic']." ".$datosPac['segundoNombrePsi']." ".$datosPac['paternoPsi'];
}else{
    $nombrePsicologo = $datosPac['primerNombrePsic']." ".$datosPac['segundoNombrePsi']." ".$datosPac['paternoPsi'].' '.$datosPac['maternoPsi'];
}

$fecha_nacimiento = $datosPac['fecha_nacimiento'];
$fecha_actual = date("Y-m-d");
$edad_diff = date_diff(date_create($fecha_nacimiento), date_create($fecha_actual));
$edad = $edad_diff->format('%y');

$pdf = new PDF('L', 'mm', 'letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', 'B',16);
$pdf->Cell(260,12,'Paciente: '.utf8_decode($nombrePaciente),0,1, 'C');
$pdf->Ln(10);

//encabezado de la tabla
$pdf->Cell(23,12,'',0,0,'C');//fila vacia para centrar

$pdf->SetFillColor(64, 158, 230);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(80,12,utf8_decode('Psicólogo asignado'),1,0,'C', 1);
$pdf->Cell(30,12,'Edad',1,0,'C', 1);
$pdf->Cell(55,12,utf8_decode('Sesiones totales'),1,0,'C', 1);
$pdf->Cell(50,12,'Estatus',1,1,'C', 1);


//busco cuantos pacientes ACTIVOS tiene cada psicologo
$sqlGetNumeroSesionesPac = "SELECT COUNT(id_sesion) as numeroSesiones FROM sesiones where id_paciente = '$idPaciente' AND mostrar = 1";
$resultadoGetNumeroSesionesPac = mysqli_query($con, $sqlGetNumeroSesionesPac);
$totalSesiones = mysqli_fetch_assoc($resultadoGetNumeroSesionesPac);

//busco la primer sesion que tuvo el paciente
$sqlGetFirstSesion="SELECT fecha_dia AS primerSesion, fecha_hora_inicio, fecha_hora_fin FROM sesiones WHERE id_paciente = '$idPaciente' AND mostrar = 1 ORDER BY fecha_dia LIMIT 1";
$resultadoGetFirstSesion=mysqli_query($con, $sqlGetFirstSesion);
$primerSesion = mysqli_fetch_assoc($resultadoGetFirstSesion);

//busco la última sesion que tuvo el paciente
$sqlGetLastSesion="SELECT fecha_dia AS ultimaSesion, fecha_hora_inicio, fecha_hora_fin FROM sesiones WHERE id_paciente = '$idPaciente' AND mostrar = 1 ORDER BY fecha_dia DESC LIMIT 1";
$resultadoGetLastSesion=mysqli_query($con, $sqlGetLastSesion);
$ultimaSesion = mysqli_fetch_assoc($resultadoGetLastSesion);

//cuerpo de la tabla
$pdf->Cell(23,12,'',0,0,'C'); //fila vacia para centrar contenido

$pdf->SetFont('Arial', '',14);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(80,12,utf8_decode($nombrePsicologo),1,0,'C', 1);
$pdf->Cell(30,12,utf8_decode($edad.' años'),1,0,'C', 1);
$pdf->Cell(55,12,$totalSesiones['numeroSesiones'],1,0,'C', 1);
$pdf->Cell(50,12,utf8_decode($datosPac['descripcion']),1,1,'C', 1);

//datos adicionales
$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(50,20,utf8_decode('Correo electrónico: '),0,0,'L');//------------PRIMER TEXTO------------
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(50,20,utf8_decode($datosPac['correo']),0,1,'L');//------------SEGUNDO TEXTO------------

$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(50,0,utf8_decode('Número telefónico: '),0,0,'L');//------------PRIMER TEXTO------------ 
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(50,00,utf8_decode($datosPac['telefono']),0,1,'L');//------------SEGUNDO TEXTO------------

$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(50,20,utf8_decode('Primera sesión: '),0,0,'L');//------------PRIMER TEXTO------------
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(100,20,$primerSesion['primerSesion'].' de '.$primerSesion['fecha_hora_inicio'].' a '.$primerSesion['fecha_hora_fin'],0,1,'L');//------------SEGUNDO TEXTO------------

$pdf->SetFont('Arial', 'B', 12);
$pdf -> Cell(50,0,utf8_decode('Última sesión: '),0,0,'L');//------------PRIMER TEXTO------------
$pdf->SetFont('Arial', '', 12);
$pdf -> Cell(100,0,$ultimaSesion['ultimaSesion'].' de '.$ultimaSesion['fecha_hora_inicio'].' a '.$ultimaSesion['fecha_hora_fin'],0,1,'L');//------------SEGUNDO TEXTO------------


$pdf->Output('D', utf8_decode('ReporteIndividual_'.$nombrePacienteReporte.'.pdf')); //'D', 'Reporte-general.pdf'