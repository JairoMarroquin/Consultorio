<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 2 || $_SESSION['usuario']['rol'] == 3){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo
?>

<!-- Page Content -->
<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Reportes de mis pacientes</h1>
      <p class="lead">Esta seccion esta en construcción, estará disponible lo más pronto posible.</p>
  </div>
</div>

<?php
include "footer.php";
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>