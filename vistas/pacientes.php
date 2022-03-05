<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 1){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo
?>

<div >
  <div class="container">
    <div class="card border-0 shadow my-5 mx-auto" >
      <div class="card-body p-5">
        <h1 class="fw-light">Administrar pacientes</h1>
        <hr>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarPacientes"><span class="fas fa-user-plus"></span> Agregar Paciente</button>
        <hr>
        <div id="tablaPacientesLoad"></div>
    </div>
  </div>
</div>

<?php
include "footer.php";
include "pacientes/modalAgregar.php";
include "pacientes/modalEditarPaciente.php";
?>

<script src="../public/js/usuarios/pacientes.js"></script>

<?php
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>