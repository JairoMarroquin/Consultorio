<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 1 || $_SESSION['usuario']['rol'] == 2){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo
?>

<!-- Page Content -->
<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Finanzas</h1>
      <hr>
      <p class="lead ">
        <div class="alert alert-warning">
          <strong>Sección no disponible en este momento.</strong> 
        </div>
      </p>
  </div>
</div>

<?php
include "footer.php";
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>