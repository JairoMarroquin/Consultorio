<?php
header('Content-type: text/css');
include "../clases/Conexion.php";
  $conexion = new Conexion;
  $con = $conexion->conectar();
  $sqlTot = "SELECT COUNT(id_sesion) as sesionesTot from sesiones";
  $sqlInd = "SELECT COUNT(id_sesion) as sesionesInd from sesiones WHERE tipo_sesion = 1;";
  $sqlPar = "SELECT COUNT(id_sesion) as sesionesPar from sesiones WHERE tipo_sesion = 2;";
  $resultadoTot = mysqli_query($con, $sqlTot);
  $resultadoInd = mysqli_query($con, $sqlInd);
  $resultadoPar = mysqli_query($con, $sqlPar);
  $tot = mysqli_fetch_array($resultadoTot);
  $ind = mysqli_fetch_array($resultadoInd);
  $par = mysqli_fetch_array($resultadoPar);

  //PORCENTAJES

  $porcentajeInd = (round(($ind['sesionesInd']*100)/$tot['sesionesTot'], 2))."%";
  $porcentajePar = (round(($par['sesionesPar']*100)/$tot['sesionesTot'], 2))."%";
  
  ?>

:root{
    --color_individual: #2992cf;
    --color_pareja: #bd3a31;
}

.title_grafico_sesiones{
    margin-top: 100px;
    text-align: center;
}
.container_grafico_sesiones{
    width: 700px;
    height: 550px;
    display: flex;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
}

.grafico_sesiones{
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background-image: conic-gradient(var(--color_individual) <?php echo $porcentajeInd;?>,
                                    var(--color_pareja) 40% <?php echo $porcentajeInd;?>);
    box-shadow: 1px 1px 5px 1px rgb(70, 70, 70);
}