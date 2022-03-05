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

//se crea un objeto DateTime para fecha de vencimiento
$fechaVencimiento = $fechaSistema['fecha_vencimiento'];
$fecha = date_create($fechaVencimiento);
$fechaCorregidaFin = date_format($fecha, 'd-m-Y');

//se crea un objeto DateTime para fecha de inicio
$fechaInicio = $fechaSistema['fecha_inicio'];
$fechaIn = date_create($fechaInicio);
$fechaCorregidaIni = date_format($fechaIn, 'd-m-Y');

if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] > 0){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo
?>
<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Acerca de</h1>
      <hr>
        <center><h4><div class="about" style="margin-top: 4%;color: #003565;">
          <div class="fecha_inicio" >
            <span class="fas fa-hourglass-start"></span> Inicio del contrato: <strong style = "color: #6e6e6e;"><?php echo $fechaCorregidaIni;?></strong>
          </div>
          <div class="fecha_fin">
            <span class="fas fa-hourglass-end"></span> Fin del contrato: <strong><span style="color:#23C000;"><?php if($fechaVencimiento == '-1'){ ?><span style="color: #818181;"><?php echo 'Perpetuo';?></span><?php }else{ ?><span style="color:green;"><?php echo $fechaCorregidaFin; ?></span><?php } ?></span></strong>
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