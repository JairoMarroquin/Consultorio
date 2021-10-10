function loginUsuario(){
    
    $.ajax({
        type: "POST",
        data: $('#frmLogin').serialize(),
        url:"procesos/usuarios/login/loginUsuario.php", //recoge la respuesta del mysqli
        success:function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                window.location.href="vistas/inicio.php";
            } else{
                swal.fire("Error al ingresar", ""+ respuesta, "error");
            }
        }
    });

    return false;
}