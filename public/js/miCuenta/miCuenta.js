function editarCuenta(){
    $.ajax({
        method: "POST",
        data: $('#frmEditarCuenta').serialize(),
        url: "../procesos/miCuenta/editarCuenta.php",
        success:function(respuesta){
            if(respuesta == 1){
                $('#modalEditarCuenta').modal('hide');
                Swal.fire(
                    'Datos actualizados',
                    'Datos actualizados correctamente',
                    'success'
                );
            }else{
                swal.fire("Error al actualizar datos", ""+respuesta, "error");
            }
        }
    });
}

function confirmAccEdit(){
    event.preventDefault();
    swal.fire({
        title: 'Actualizar datos',
        text: "Confirmación de actualización de cuenta.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0c87fa',
        cancelButtonColor: '#8a8a8a',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Actualizar'
        
      }).then((result) => {
        if (result.isConfirmed) {
            editarCuenta();
        }
      })
}

function getDatosCuenta(idCuenta){
$('#frmEditarCuenta').val('');
$.ajax({
    method: "POST",
    data: "idUsuarioEditar="+idCuenta,
    url: "../procesos/usuarios/usuarios/obtenerDatosEditar.php",
    success: function(respuesta){
        respuesta = jQuery.parseJSON(respuesta);
        $('#frmEditarCuenta')[0].reset();
        $('#primer_nombreEd').val(respuesta['primerNombre']);
        $('#segundo_nombreEd').val(respuesta['segundoNombre']);
        $('#apellido_paternoEd').val(respuesta['apellidoPaterno']);
        $('#apellido_maternoEd').val(respuesta['apellidoMaterno']);
    }
});
}
