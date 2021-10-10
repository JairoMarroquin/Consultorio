<?php
ob_start();
date_default_timezone_set("America/Monterrey");
include "header.php";
include "../clases/Conexion.php";
$con = new Conexion();
$conexion = $con -> conectar();

$queryGetVersion="SELECT version as version FROM version_producto ORDER BY id_version DESC LIMIT 1"; //toma la ultima version
$queryGetFechaVencimiento="SELECT fecha_vencimiento, fecha_inicio FROM contrato order by id_contrato DESC LIMIT 1"; //toma las fechas del ultimo contrato
$respuesta = mysqli_query($conexion, $queryGetVersion);
$versionActual = mysqli_fetch_assoc($respuesta);
$respuestaFechas = mysqli_query($conexion, $queryGetFechaVencimiento);
$fechaSistema = mysqli_fetch_assoc($respuestaFechas);
/*$fechaVencimientoDB = strtotime($fechaSistema['fecha_vencimiento']);
valores vencimiento
$fechaVencimientoCompleta=strtotime(date("Y-m-d"));
$añoVencimiento= date("Y", $fechaVencimientoDB);
$mesVencimiento= date("m", $fechaVencimientoDB);
$diaVencimiento= date("d", $fechaVencimientoDB);
//valores actuales
$añoActual= date("Y");
$mesActual= date("m");
$diaActual= date("d");
//dateTime
$d= new DateTime();
//validar si el sistema esta proximo a vencer

if($añoVencimiento == $añoActual && $mesVencimiento ){

}*/

if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] > 0){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo
?>
<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Acerca De</h1>
      <hr>
        <center><h4><div class="about" style="margin-top: 4%;color: #1c6bff;">
          <div class="fecha_inicio" >
            <span class="fas fa-hourglass-start"></span> Inicio del contrato: <strong><?php echo $fechaSistema['fecha_inicio'];?></strong>
          </div>
          <div class="fecha_fin">
            <span class="fas fa-hourglass-end"></span> Fin del contrato: <strong><span style="color:#23C000;"><?php if($fechaSistema['fecha_vencimiento'] == '-1'){ ?><span style="color: #818181;"><?php echo 'Perpetuo';?></span><?php }else{ ?><span style="color:green;"><?php echo $fechaSistema['fecha_vencimiento']; ?></span><?php } ?></span></strong>
          </div>
          <div class="version" style="margin-top: 2%;">
            <span class="fas fa-code"></span> <span>Versión: <?php echo $versionActual['version'];?></span>
        </div></h4></center>
  </div>
</div>

<?php
include "footer.php";
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>