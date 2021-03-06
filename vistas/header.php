<?php
  session_start();
  include "miCuenta/modalMiCuenta.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="latin1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/plantilla.css">
    <link rel="stylesheet" href="../public/css/graficos.css">
    <link rel="stylesheet" href="../public/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/fontawesome/css/all.css">
    <link rel="stylesheet" href="../public/datatable/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/materialize/css/materialize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400&display=swap" rel="stylesheet">
    <title>Consultorio</title>
</head>
<body>
  
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="font-family: 'Titillium Web', sans-serif; font-size: 19px;">
  <div class="container-fluid" style = "width: 200%;">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav mx-auto justify-content-center">
        <div class="navbar-brand" id="time"></div> <!-- reloj-->
          <li class="nav-item">
            <a class="nav-link" href="inicio.php">
            Inicio
            </a>
          </li>
            <!-- Opciones de colaborador y administrador (id_usuario = 1 && 2)-->
          <?php if($_SESSION['usuario']['rol'] == 2 || $_SESSION['usuario']['rol'] == 3){ //Modulo 'Mis Pacientes' solo lo pueden ver admins y colaboradores?>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
              <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-menu" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pacientes
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="misPacientes.php"><span class="fas fa-list-ul"></span> Mis Pacientes</a></li>
                          <li><a class="dropdown-item" href="misCitas.php"><span class="far fa-calendar-alt"></span> Citas de mis pacientes</a></li>
                          <li><a class="dropdown-item" href="misSesiones.php"><span class="far fa-calendar-check"></span> Registrar Sesi??n</a></li>
                      </ul>
                  </li>
              </ul>
            </div>
          <?php }?>
          <?php if($_SESSION['usuario']['rol'] == 1) { //si rol = 1 o 2 puede ver Pacientes y Reportes?>
              <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="dropdown-trigger" data-target="pacientes_admin" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                          Pacientes
                        </a>
                    </li>
                    <ul class="dropdown-content" aria-labelledby="navbarDropdown" id="pacientes_admin">
                        <li><a class="dropdown-item" href="pacientes.php"><span class="fas fa-list-ul"></span> Pacientes</a></li>
                        <li><a class="dropdown-item" href="citas.php"><span class="far fa-calendar-alt"></span> Citas de pacientes</a></li>
                        <li><a class="dropdown-item" href="sesiones.php"><span class="far fa-calendar-check"></span> Registrar Sesi??n</a></li>
                    </ul>
                </ul>
              </div>
          <?php } if($_SESSION['usuario']['rol'] == 1 || $_SESSION['usuario']['rol'] == 2){ //Si rol = 1 puede ver Administraci??n y Admin Usuarios, si rol =2 no puede verlos ?>
          <!-- De aqui en delante las vistas son exclusivas de administrador (id_usuario = 1)-->
    
          <li class="nav-item">
            <a class="nav-link" href="administracionUsuarios.php">Usuarios del sistema</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Administracion.php">Administraci??n</a>
          </li>
          <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
              <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                        Cat??logos
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="motivosConsulta.php">Motivos de consulta</a></li>
                          <li><a class="dropdown-item" href="tecnicas.php">T??cnicas</a></li>
                      </ul>
                  </li>
              </ul>
        </div>
          <?php } ?>
          <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
              <ul class="navbar-nav" id="ultimo">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                          Hola, <?php echo $_SESSION['usuario']['nombre'];?> <?php echo $_SESSION['usuario']['segundo_nombre'];?> <?php echo $_SESSION['usuario']['apellido'];?> <?php echo $_SESSION['usuario']['apellido_materno'];?>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                          <li>
                            <a class="dropdown-item" href="acercaDe.php">
                              <span class="fas fa-info-circle"></span>
                              Acerca de
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="" onclick="return getDatosCuenta(<?php echo $_SESSION['usuario']['id'];?>)" data-bs-toggle="modal" data-bs-target="#modalEditarCuenta">
                              <span class="fas fa-user-cog"></span>
                              Mi cuenta
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="../procesos/usuarios/login/salir.php">
                              <span class="fas fa-sign-out-alt"></span>
                              Salir
                            </a>
                          </li>
                      </ul>
                  </li>
              </ul>
        </div>
      </ul>
    </div>
  </div>
</nav>
<!-- Merriweather Sans   -->
<script src="../public/js/miCuenta/miCuenta.js"></script>
<div style="font-family: 'Cabin', sans-serif;">

