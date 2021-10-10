<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] < 3){ 
?>

<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Motivos de consulta</h1>
      <hr>
      <button class="btn btn-outline-primary"><span class="fas fa-plus-square"></span> Agregar motivo de consulta</button>
      <hr>
      <div id="tablaMotivosLoad"></div>
  </div>
</div>

<?php
include "footer.php";
?>

<script src="../public/js/motivos/motivos.js"></script>

<?php
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>