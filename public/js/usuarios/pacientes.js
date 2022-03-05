$(document).ready(function(){
    $('#tablaPacientesLoad').load("pacientes/tablaPacientes.php"); //toma de: vistas/pacientes.php y carga a nivel pacientes.php de: pacientes/tablaPacientes.php 
}); 

function eliminarPaciente(idPaciente){
    id= {"id":idPaciente};
    $.ajax({
        method: "POST",
        data: id,
        url: "../procesos/pacientes/eliminarPaciente.php",
        success: function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaPacientesLoad').load("pacientes/tablaPacientes.php");
                $("#modalEditarPaciente").modal('hide');
                swal.fire("¡Listo!", "Paciente eliminado con éxito", "success");
            }else{
                swal.fire("Error al eliminar al paciente", ""+respuesta, "error");
            }
        }
    });
    return false;
}

document.getElementById("optPac").addEventListener("click", function (event) {
    event.preventDefault();
});

function confirmDelete(idPaciente){
    event.preventDefault()
    Swal.fire({
        title: '¿Seguro que quieres eliminar el paciente?',
        text: "No podrás recuperar el registro.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0c87fa',
        cancelButtonColor: '#8a8a8a',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
      }).then((result) => {
        if (result.isConfirmed) {
            eliminarPaciente(idPaciente);
        }
      })
}

function editarPrimeraVezPaciente(idPaciente){
    id= {"id":idPaciente};
    $.ajax({
        method: "POST",
        data:  id,
        url: "../procesos/pacientes/editarPrimeraVez.php",
        success: function(respuesta){
            console.log(respuesta);
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaPacientesLoad').load("pacientes/tablaPacientes.php");
                $("#frmEditarPrimeraVezPaciente")[0].reset();
                swal.fire("¡Listo!","Estatus cambiado con éxito", "success");
            }else{
                swal.fire("Error al actualizar estatus", "No se pudo quitar estatus: " + respuesta, "error");
            }
        }
    });
    return false;
}

function confirmDeleteFirstTime(idPaciente){
    Swal.fire({
        title: '¿Este paciente ya no es primera vez?',
        text: "No podrás regresar el estatus.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2B8EFF',
        cancelButtonColor: '#929292',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
            editarPrimeraVezPaciente(idPaciente);
        }
      }) 
}

function agregarNuevoPaciente(){
    $.ajax({
        type: "POST", 
        data: $("#frmAgregarPaciente").serialize(),
        url: "../procesos/pacientes/agregarNuevoPaciente.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaPacientesLoad').load("pacientes/tablaPacientes.php");
                $("#frmAgregarPaciente")[0].reset(); //resetea el formulario para poder dar de alta otro paciente
                swal.fire("¡Éxito!", "Paciente agregado con éxito!", "success");
            }  else{
                swal.fire("Error al agregar paciente", "" + respuesta, "error");
            }
        }
    });
    return false;
}

function obtenerIDPaciente(idPaciente){ 
    $('#idPaciente').val('');
    $.ajax({
        type: "POST",
        data: "idPaciente="+idPaciente,
        url: "../procesos/pacientes/editarPrimeraVez.php",
        success:function(respuesta){
            console.log(respuesta);
            $('#idPaciente').val(idPaciente); //le asigno el valor a idPaciente
        }
    });
}

function obtenerIDPacienteEliminar(idPacienteEliminar){ 
    $('#idPacienteEliminar').val('');
    $.ajax({
        type: "POST",
        data: "idPacienteEliminar="+idPacienteEliminar,
        url: "../procesos/pacientes/eliminarPaciente.php",
        success:function(respuesta){
            console.log(respuesta);
            $('#idPacienteEliminar').val(idPacienteEliminar); //le asigno el valor a idPaciente
        }
    });
}

function obtenerDatosPacienteEditar(idPacienteEditar){ 
    $('#frmEditarPaciente').val('');
    $.ajax({
        type: "POST",
        data: "idPacienteEditar="+idPacienteEditar,
        url: "../procesos/pacientes/obtenerDatosEditar.php",
        success:function(respuesta){
            respuesta = jQuery.parseJSON(respuesta); //INSERTA LOS VALORES RECOGIDOS DE LA BD EN LOS CAMPOS
            $('#idPacienteEditar').val(respuesta['idPaciente']);
            $('#primer_nombreu').val(respuesta['nombrePaciente']);
            $('#segundo_nombreu').val(respuesta['segundoNombre']);
            $('#apellido_paternou').val(respuesta['apellidoPaternoPaciente']);
            $('#apellido_maternou').val(respuesta['apellidoMaternoPaciente']);
            $('#fecha_nacimientou').val(respuesta['fechaNacimiento']);
            $('#sexou').val(respuesta['sexo']);
            $('#telefonou').val(respuesta['telefono']);
            $('#correou').val(respuesta['correo']);
            $('#psicologo_encargadou').val(respuesta['idPsicologo']); 
            $('#estatus_paciente').val(respuesta['estatusPaciente']);
        }
    });
}

function editarPaciente(){
    $.ajax({
        method: "POST",
        data: $('#frmEditarPaciente').serialize(),
        url: "../procesos/pacientes/editarPaciente.php",
        success: function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaPacientesLoad').load("pacientes/tablaPacientes.php");
                $("#modalEditarPaciente").modal('hide');
                swal.fire("¡Listo!", "Paciente actualizado con éxito", "success");
            }else{
                console.log(respuesta); 
                swal.fire(":(", ""+respuesta, "error");
            }
        }
    });
    return false;
}
