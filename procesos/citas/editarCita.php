<?php
    include "../../clases/Citas.php";
    $Citas = new Citas();

    $datos = array(
        'id_paciente' => $_POST['pacienteu'],
        'tipo_sesion' => $_POST['tipo_sesionu'],
        'fecha_dia' => $_POST['diau'],
        'fecha_hora' => $_POST['hora_citau'],
        'notas' => $_POST['notasu'],
        'idCitaEditar' => $_POST['idCitaEditar']
    );

    echo $Citas -> editarCita($datos);
