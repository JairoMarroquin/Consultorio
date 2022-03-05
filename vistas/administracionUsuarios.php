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
    <h1 class="fw-light">Usuarios del sistema</h1>
      <p class="lead">
        <hr>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuarios"><span class="fas fa-user-plus"></span> Agregar Usuario</button>
        <hr>
        <div id="tablaUsuariosLoad"></div>
      </p>
  </div>
</div>

<?php
include "usuarios/modalAgregarUsuarios.php";
include "usuarios/modalDesactivarUsuario.php";
include "usuarios/modalActivarUsuario.php";
include "usuarios/modalEditarUsuario.php";
include "footer.php";
?>

<script src= "../public/js/altaUsuarios/altaUsuarios.js"></script>

<?php
}else{//se cierra la validacion del if
  header('location:../index.html');
} 

?>