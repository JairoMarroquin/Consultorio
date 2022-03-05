<?php
ob_start();
include "header.php";
if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 1 || $_SESSION['usuario']['rol'] == 2){ 
  //si se inicio sesion y ademas tiene rol 1 o 2 el usuario puede ver el contenido de abajo

  include "../clases/Conexion.php";
  $conexion = new Conexion;
  $con = $conexion->conectar();
  //SESIONES
  $sqlTot = "SELECT COUNT(id_sesion) as sesionesTot from sesiones";
  $sqlInd = "SELECT COUNT(id_sesion) as sesionesInd from sesiones WHERE tipo_sesion = 1;"; //sesiones individuales
  $sqlPar = "SELECT COUNT(id_sesion) as sesionesPar from sesiones WHERE tipo_sesion = 2;";
  $sqlConCita="SELECT COUNT(id_sesion) as citaSi from sesiones where cita = 1"; //sesiones con cita
  $sqlSinCita="SELECT COUNT(id_sesion) as citaNo from sesiones where cita = 2";
  $resultadoTot = mysqli_query($con, $sqlTot);
  $resultadoInd = mysqli_query($con, $sqlInd);
  $resultadoPar = mysqli_query($con, $sqlPar);
  $resultadoConCita= mysqli_query($con, $sqlConCita);
  $resultadoSinCita= mysqli_query($con, $sqlSinCita);
  $tot = mysqli_fetch_assoc($resultadoTot);
  $ind = mysqli_fetch_assoc($resultadoInd);
  $par = mysqli_fetch_assoc($resultadoPar);
  $citaSi=mysqli_fetch_assoc($resultadoConCita);
  $citaNo=mysqli_fetch_assoc($resultadoSinCita);

  //PACIENTES
  $sqlTotPacientes="SELECT COUNT(id_paciente) as totPacientes from pacientes";
  $sqlPacActivo="SELECT COUNT(id_paciente) as pacAct from pacientes WHERE id_estatus = 1";
  $sqlPacBaja="SELECT COUNT(id_paciente) as pacBaj from pacientes WHERE id_estatus = 2";
  $sqlPacAlta="SELECT COUNT(id_paciente) as pacAlt from pacientes WHERE id_estatus = 3";
  $sqlPacCanalizado="SELECT COUNT(id_paciente) as pacCan from pacientes WHERE id_estatus = 4";
  $resultadoPacTot = mysqli_query($con, $sqlTotPacientes);
  $resultadoPacAct = mysqli_query($con, $sqlPacActivo);
  $resultadoPacBaj = mysqli_query($con, $sqlPacBaja);
  $resultadoPacAlt= mysqli_query($con, $sqlPacAlta);
  $resultadoPacCan= mysqli_query($con, $sqlPacCanalizado);
  $pacTot = mysqli_fetch_assoc($resultadoPacTot);
  $pacAct = mysqli_fetch_assoc($resultadoPacAct);
  $pacBaj = mysqli_fetch_assoc($resultadoPacBaj);
  $pacAlt=mysqli_fetch_assoc($resultadoPacAlt);
  $pacCan=mysqli_fetch_assoc($resultadoPacCan);


  //PORCENTAJES

  //SESIONES
  if($tot['sesionesTot'] == 0){
    $porcentajeInd = "No hay datos:";
    $porcentajePar = "No hay datos:";
  
    $porcentajeConCita = "No hay datos:";
    $porcentajeSinCita = "No hay datos:";
  }else{
    $porcentajeInd = (round(($ind['sesionesInd']*100)/$tot['sesionesTot'], 2))."%";
    $porcentajePar = (round(($par['sesionesPar']*100)/$tot['sesionesTot'], 2))."%";
  
    $porcentajeConCita = (round(($citaSi['citaSi']*100)/$tot['sesionesTot'], 2))."%";
    $porcentajeSinCita = (round(($citaNo['citaNo']*100)/$tot['sesionesTot'], 2))."%";
  }

  //PACIENTES

  if($pacTot['totPacientes'] == 0){
    $porcentajePacAct = "No hay datos:";
    $porcentajePacBaj = "No hay datos:";
    $porcentajePacAlt = "No hay datos:";
    $porcentajePacCan= "No hay datos:";
  }else{
    $porcentajePacAct = (round(($pacAct['pacAct']*100)/$pacTot['totPacientes'], 2))."%";
    $porcentajePacActNat = (round($pacAct['pacAct']*100)/$pacTot['totPacientes']); //variable para grafica sin '%'
    $porcentajePacBaj = (round(($pacBaj['pacBaj']*100)/$pacTot['totPacientes'], 2))."%";
    $porcentajePacBajNat = (round($pacBaj['pacBaj']*100)/$pacTot['totPacientes']);//variable para grafica sin '%'
    $porcentajePacAlt = (round(($pacAlt['pacAlt']*100)/$pacTot['totPacientes'], 2))."%";
    $porcentajePacAltNat = (round($pacAlt['pacAlt']*100)/$pacTot['totPacientes']);//variable para grafica sin '%'
    $porcentajePacCan= (round(($pacCan['pacCan']*100)/$pacTot['totPacientes'], 2))."%";
    
    //CALCULOS PARA GRAFICA DE ESTATUS DE PACIENTES
    $baja = ($porcentajePacActNat+$porcentajePacBajNat)."%";
    $alta = ($porcentajePacActNat+$porcentajePacBajNat+$porcentajePacAltNat)."%";
    
  }
?>
<style>
  <?php
    if($tot['sesionesTot'] == 0){ //variables para sesiones?>
      :root{
        --color_individual: #2e2e2e;
        --color_pareja: #2e2e2e;

        --porcentajeInd:0;
        --porcentajePar:0;
        --porcentajeConCita:0;
        --porcentajeSinCita:0;
      }
    <?php }else{ ?>
      :root{
        --color_individual: #2992cf;
        --color_pareja: #e64237;

        --porcentajeInd:<?php echo $porcentajeInd;?>;
        --porcentajePar:<?php echo $porcentajePar;?>;
        --porcentajeConCita:<?php echo $porcentajeConCita;?>;
        --porcentajeSinCita:<?php echo $porcentajeSinCita;?>;
      }<?php
    }
  ?>
    <?php
    if($pacTot['totPacientes'] == 0){ //variables para pacientes?>
      :root{
        --color_activo: #2e2e2e;
        --color_baja: #2e2e2e;
        --color_alta: #2e2e2e;
        --color_canalizado: #2e2e2e;

        --porcentajePacAct:0;
        --porcentajePacBaj:0;
        --porcentajePacAlt:0;
        --porcentajePacCan:0;
      }
    <?php }else{ ?>
      :root{
        --color_activo: #00B000;
        --color_baja: #ff1212;
        --color_alta: #0007cc;
        --color_canalizado: #F39C12;

        --porcentajePacAct:<?php echo $porcentajePacAct;?>;
        --porcentajePacBaj:<?php echo $porcentajePacBaj;?>;
        --porcentajePacAlt:<?php echo $porcentajePacAlt;?>;
        --porcentajePacCan:<?php echo $porcentajePacCan;?>;
        
        --baja:<?php echo $baja;?>;
        --alta:<?php echo $alta;?>;
      }<?php
    }
  ?>
</style>
<!-- Page Content -->
<div class="container">
  <div class="card border-0 shadow my-5">
    <div class="card-body p-5">
      <h1 class="fw-light">Administración general</h1>
      <hr>
      <h1 class="title_grafico_sesiones">Sesiones</h1>
        <div class="tier_1">
          <div class="citas">
            <br>
            <section class="container_grafico_sesiones">
              <div class ="grafico_sesiones">
                <div class="container_leyenda">
                  <span class="leyenda_all">
                    <span class="color_individual"></span>
                    <p class="individual"><strong><?php echo $porcentajeInd;?></strong> Individual</p>
                  </span>
                  <span class="leyenda_all">
                    <span class="color_pareja"></span>
                    <p class="pareja"><strong><?php echo $porcentajePar;?></strong> Pareja</p>
                  </span>
                </div>
              </div>
            </section>
          </div>
          <div class="sesiones">
            <br>
            <section class="container_grafico_citas">
              <div class ="grafico_citas">
                <div class="container_leyenda">
                  <span class="leyenda_all">
                    <span class="color_individual"></span>
                    <p class="individual"><strong><?php echo $porcentajeSinCita;?></strong> Sin cita</p>
                  </span>
                  <span class="leyenda_all">
                    <span class="color_pareja"></span>
                    <p class="pareja"><strong><?php echo $porcentajeConCita;?></strong> Con cita</p>
                  </span>
                </div>
              </div>
            </section>
          </div>
        </div>
      <h1 class="title_grafico_sesiones">Pacientes</h1>
        <div class="tier_2">
          <div class="estatus">
            <br>
            <section class="container_grafico_pacientes">
              <div class ="grafico_estatus">
                <div class="container_leyenda">
                  <span class="leyenda_all">
                    <span class="color_activo"></span>
                    <p class="individual"><strong><?php echo $porcentajePacAct;?></strong> Activo</p>
                  </span>
                  <span class="leyenda_all">
                    <span class="color_baja"></span>
                    <p class="pareja"><strong><?php echo $porcentajePacBaj;?></strong> Baja</p>
                  </span>
                  <span class="leyenda_all">
                    <span class="color_alta"></span>
                    <p class="individual"><strong><?php echo $porcentajePacAlt;?></strong> Alta</p>
                  </span>
                  <span class="leyenda_all">
                    <span class="color_canalizado"></span>
                    <p class="pareja"><strong><?php echo $porcentajePacCan;?></strong> Canalizado</p>
                  </span>
                </div>
              </div>
            </section>
          </div>
        </div>
  </div>
</div>

<?php
include "footer.php";
}else{//se cierra la validacion del if
  header('location:../index.html');
} 
ob_end_flush();
?>