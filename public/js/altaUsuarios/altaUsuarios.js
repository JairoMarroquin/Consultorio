$(document).ready(function(){
    $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
}); 

function desactivarUsuario(idUsuario){
    id={"id":idUsuario};
    $.ajax({
        method: "POST",
        data: id,
        url: "../procesos/usuarios/usuarios/desactivarUsuario.php",
        success: function(respuesta){
            console.log(respuesta);
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                swal.fire("¡Listo!", "Usuario desactivado correctamente!", "success");
            }else{
                swal.fire("Error al desactivar usuario", "No se pudo desactivar al usuario: "+respuesta, "error");
            }
        }
    });
    return false;
}

function confirmDelete(idUsuario){
    swal.fire({
        title: 'Desactivar usuario',
        text: "Podrás reactivarlo después.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0c87fa',
        cancelButtonColor: '#8a8a8a',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Desactivar'
        
      }).then((result) => {
        if (result.isConfirmed) {
            desactivarUsuario(idUsuario);
        }
      })
}

function activarUsuario(idUsuario){
    id= {"id":idUsuario};
    $.ajax({
        method: "POST",
        data: id,
        url: "../procesos/usuarios/usuarios/activarUsuario.php",
        success: function(respuesta){
            console.log(respuesta);
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                swal.fire("¡Listo!", "Usuario activado correctamente!", "success");
            }else{
                swal.fire("Error al activar usuario", "No se pudo activar el usuario: "+respuesta, "error");
            }
        }
    });
    return false;
}

function confirmActivate(idUsuario){
    Swal.fire({
        title: 'Activar usuario',
        text: "Podrás desactivarlo después.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2B8EFF',
        cancelButtonColor: '#929292',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
            activarUsuario(idUsuario);
        }
      })
}

function agregarUsuario(){
    $.ajax({
        method: "POST",
        data: $("#frmAgregarUsuario").serialize(),
        url: "../procesos/usuarios/usuarios/altaUsuario.php",
        success: function(respuesta){   
            console.log(respuesta);
            respuesta= respuesta.trim();
            if(respuesta==1){
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                $("#frmAgregarUsuario")[0].reset();
                swal.fire("¡Listo!","Usuario agregado con éxito", "success");
            }else{
                swal.fire(":(", "Error al agregar usuario: " + respuesta, "error");
            }
        }
    });
    return false;
}

function obtenerIDUsuarioDesactivar(idUsuarioDesactivar){ 
    $('#idUsuarioDesactivar').val('');
    $.ajax({
        type: "POST",
        data: "idUsuarioDesactivar="+idUsuarioDesactivar,
        url: "../procesos/usuarios/usuarios/desactivarUsuario.php",
        success:function(respuesta){
            console.log(respuesta);
            $('#idUsuarioDesactivar').val(idUsuarioDesactivar); //le asigno el valor a idPaciente
        }
    });
}

function obtenerIDUsuarioActivar(idUsuarioActivar){ 
    $('#idUsuarioActivar').val('');
    $.ajax({
        type: "POST",
        data: "idUsuarioActivar="+idUsuarioActivar,
        url: "../procesos/usuarios/usuarios/activarUsuario.php",
        success:function(respuesta){
            console.log(respuesta);
            $('#idUsuarioActivar').val(idUsuarioActivar); //le asigno el valor a idUsuarioActivar
        }
    });
}

function obtenerDatosUsuario(idUsuarioEditar){
    $('#frmEditarUsuario').val('');
    $.ajax({
        method: "POST",
        data: "idUsuarioEditar="+idUsuarioEditar,
        url:  "../procesos/usuarios/usuarios/obtenerDatosEditar.php",
        success: function(respuesta){
            respuesta = jQuery.parseJSON(respuesta);
            $('#frmEditarUsuario')[0].reset();
            $('#idUsuarioEditar').val(respuesta['idUsuarioEditar']);
            $('#primer_nombreu').val(respuesta['primerNombre']);
            $('#segundo_nombreu').val(respuesta['segundoNombre']);
            $('#apellido_paternou').val(respuesta['apellidoPaterno']);
            $('#apellido_maternou').val(respuesta['apellidoMaterno']);

            if(respuesta['usuarioRol'] == 2){ //marca el checkbox para el rol del usuario
                $('#rolAdu').prop("checked", true);
                $('#rolCou').prop("checked", false);
            }else{
                $('#rolAdu').prop("checked", false);
                $('#rolCou').prop("checked", true);
            }

            if(respuesta['psicologo'] == 1){//marca el checkbox para el bit_psicologo
                $('#radioSiu').prop("checked", true);
                $('#radioNou').prop("checked", false);
            }else{
                $('#radioSiu').prop("checked", false);
                $('#radioNou').prop("checked", true);
            }

        }
    });
}

function editarUsuario(){
    $.ajax({
        method: "POST",
        data: $('#frmEditarUsuario').serialize(),
        url: "../procesos/usuarios/usuarios/editarUsuario.php",
        success: function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                $("#modalEditarUsuario").modal('hide');
                swal.fire("¡Listo!", "Paciente actualizado con éxito", "success");
            }else{
                swal.fire(":(", "Error al actualizar al paciente: "+respuesta, "error");
            }
        }
    });
    return false;
}