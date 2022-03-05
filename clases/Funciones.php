<?php

class Funciones{

    function calculaEdad($fechaNacimiento){
        list($ano, $mes, $dia) = explode("-",$fechaNacimiento);
        $anoDif =  date('Y') - $ano;
        $mesDif = date('m') - $mes;
        $diaDif = date('d') - $dia;

        if($diaDif < 0 || $mesDif < 0){
            $anoDif--;
            return $anoDif;
        }
    }
}