<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] > 1){ 
?>
<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Registrar una sesión</h1>
      <hr>
      <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAgregarSesiones"><span class="far fa-calendar-plus"></span> Registrar sesión</button>
      <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalReporteSesion"><span class="fas fa-file-download"></span> Descargar reporte</button>
      <hr>
      <div id="tablaSesionesLoad"></div>
  </div>
</div>
 
<?php
include "footer.php";
include "sesiones/modalAgregarSesion.php";
include "sesiones/modalEditarSesion.php";
include "sesiones/modalReporteSesiones.php";
?>

<script src="../public/js/sesiones/sesiones.js"></script>

<?php
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>