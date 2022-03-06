<?php
class Conexion{
    public function conectar(){
        $servidor="localhost"; //localhost:3306
        $usuario= "root"; //yourjnls_admin
        $password=""; //12345JairoMarroquin
        $db="luz"; //yourjnls_luz
        $conexion =  mysqli_connect($servidor, $usuario, $password, $db);
        mysqli_query($conexion, "SET NAMES 'utf8'");
        return $conexion;
    } 
}

?>