<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 1){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo
?>

<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Registrar una sesión</h1>
      <hr>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarSesiones"><span class="far fa-calendar-plus"></span> Registrar sesión</button>
      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalReporteSesion"><span class="fas fa-file-download"></span> Descargar reporte</button>
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