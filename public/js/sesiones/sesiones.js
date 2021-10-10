$(document).ready(function(){
    $('#tablaSesionesLoad').load("sesiones/tablaSesiones.php"); 
});

function eliminarSesion(idSesion){
    id= {"id":idSesion};
    $.ajax({
        method: "POST",
        data: id,
        url: "../procesos/sesiones/eliminarSesion.php",
        success: function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaSesionesLoad').load("sesiones/tablaSesiones.php");
                swal.fire("¡Éxito!", "Sesión eliminada correctamente", "success");
            }else{
                swal.fire("Error", "No fue posible eliminar la sesión por: "+respuesta, "error");
            }
        }
    });
}

function confirmDelete(idSesion){
    Swal.fire({
        title: '¿Seguro que quieres eliminar la sesión?',
        text: "No podrás recuperar el registro.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0c87fa',
        cancelButtonColor: '#8a8a8a',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
      }).then((result) => {
        if (result.isConfirmed) {
            eliminarSesion(idSesion);
        }
      })
}

$('#frmAgregarSesion').on('submit', agregarNuevaSesion);

function agregarNuevaSesion(){
    $.ajax({
        method: "POST",
        data: $('#frmAgregarSesion').serialize(),
        url: "../procesos/sesiones/agregarSesion.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaSesionesLoad').load("sesiones/tablaSesiones.php");
                $('#frmAgregarSesion')[0].reset();
                swal.fire("¡Éxito!", "Sesión agregada con éxito!", "success");
            }else{
                swal.fire("Error al registrar sesión", ""+respuesta, "error");
            }
        }
    });
    return false;
}

function obtenerDatosSesionEditar(idSesionEditar){
    $('#frmEditarSesion').val('');
    $.ajax({
        method: "POST",
        data: "idSesionEditar="+idSesionEditar,
        url: "../procesos/sesiones/obtenerDatosSesionEditar.php",
        success: function(respuesta){
            respuesta = jQuery.parseJSON(respuesta);
            $('#idSesionEditar').val(respuesta['idSesion']);
            $('#pacienteU').val(respuesta['idPaciente']);
            $('#tipo_sesionu').val(respuesta['tipoSesion']);
            $('#diau').val(respuesta['fechaDia']);
            $('#hora_iniciou').val(respuesta['horaInicio']);
            $('#hora_finu').val(respuesta['horaFin']);
            $('#citau').val(respuesta['cita']);     
        }
    });
}

$('#frmEditarSesion').on('submit',editarSesion);

function editarSesion(){
    $.ajax({
        method: "POST",
        data: $('#frmEditarSesion').serialize(),
        url:"../procesos/sesiones/editarSesion.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta==1){
                $('#tablaSesionesLoad').load("sesiones/tablaSesiones.php");
                $('#modalEditarSesiones').modal('hide');
                swal.fire("¡Éxito!","Sesión modificada correctamente.","success");
            }else{
                swal.fire("Error",""+respuesta,"error");
            }
        }
    });

    return false;
}
