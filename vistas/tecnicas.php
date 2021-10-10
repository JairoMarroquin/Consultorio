<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] < 3){ 
?>

<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Técnicas</h1>
      <hr>
      <button class="btn btn-outline-primary"><span class="fas fa-plus-square"></span> Agregar técnica</button>
      <hr>
      <div id="tablaTecnicasLoad"></div>
  </div>
</div>

<?php
include "footer.php";
?>

<script src="../public/js/tecnicas/tecnicas.js"></script>

<?php
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>