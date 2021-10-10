<?php

    $idCitaEditar= $_POST['idCitaEditar'];
    include "../../clases/Citas.php";

    $Citas = new Citas();
    echo json_encode($Citas -> obtenerDatosCitasEditar($idCitaEditar));