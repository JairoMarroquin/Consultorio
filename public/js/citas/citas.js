$(document).ready(function(){
    $('#tablaCitasLoad').load("citas/tablaCitas.php"); 
});

function eliminarCita(idCita){
    id = {"id":idCita};
    $.ajax({
        method: "POST",
        data: id,
        url: "../procesos/citas/eliminarCita.php",
        success: function(respuesta){
            if(respuesta == 1){
                $('#tablaCitasLoad').load("citas/tablaCitas.php");
                Swal.fire(
                    'Eliminada',
                    'Cita eliminada correctamente',
                    'success'
                );
            }else{
                swal.fire("Error al eliminar cita", "No se pudo eliminar la cita: "+respuesta, "error"); 
            }
        }
    });
}

function confirmDelete(idCita){
    Swal.fire({
        title: '¿Seguro que quieres eliminar la cita?',
        text: "No podrás recuperar el registro.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0c87fa',
        cancelButtonColor: '#8a8a8a',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarCita(idCita);
        }
      })
}

$('#frmAgregarCita').on('submit', agregarCita);

function agregarCita(){
    $.ajax({
        method: "POST",
        data: $('#frmAgregarCita').serialize(),
        url: "../procesos/citas/agregarCita.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta);
            if(respuesta == 1){
                $('#tablaCitasLoad').load("citas/tablaCitas.php");
                $('#frmAgregarCita')[0].reset();
                swal.fire("¡Éxito!", "Cita agregada con éxito!", "success");
            }else{
                swal.fire("Error", ""+respuesta, "error");
            }
        }
    });
    return false;
}

function obtenerDatosEditarCita(idCitaEditar){
    $('#frmEditarCita').val('');
    $.ajax({
        method: "POST",
        data: "idCitaEditar="+idCitaEditar,
        url: "../procesos/citas/obtenerDatosCitaEditar.php",
        success: function(respuesta){
            respuesta = jQuery.parseJSON(respuesta);
            $('#idCitaEditar').val(respuesta['idCita']);
            $('#pacienteu').val(respuesta['idPaciente']);
            $('#tipo_sesionu').val(respuesta['tipoSesion']);
            $('#diau').val(respuesta['fechaDia']);
            $('#hora_citau').val(respuesta['fechaHora']);
            $('#notasu').val(respuesta['notas']);     
        }
    });
}

$('#frmEditarCita').on('submit', editarCita);

function editarCita(){
    $.ajax({
        method: "POST",
        data: $('#frmEditarCita').serialize(),
        url: "../procesos/citas/editarCita.php",
        success:function(respuesta){
            
            console.log(respuesta);
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaCitasLoad').load("citas/tablaCitas.php");
                $('#modalEditarCitas').modal('hide');
                swal.fire("¡Éxito!", "La cita ha sido editada correctamente", "success");
            }else{
                swal.fire("Error", ""+respuesta, "error");
            }
        }
    });

    return false;
}