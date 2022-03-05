<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] > 1){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo
?>

<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Citas pendientes</h1>
      <hr>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#agregarCitas"><span class="fas fa-calendar-plus"></span> Registrar Cita</button>
      <hr>
      <div id="tablaCitasLoad"></div>
  </div>
</div>

<?php
include "footer.php";
include "citas/modalAgregarCita.php";
include "citas/modalEditarCita.php";
?>

<script src= "../public/js/citas/citas.js"></script>

<?php
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>