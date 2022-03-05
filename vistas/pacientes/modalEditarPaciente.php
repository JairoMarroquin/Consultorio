<?php
    $con = new Conexion();
    $conexion = $con->conectar();
    $sql="SELECT id_usuario, primer_nombre, apellido_paterno, apellido_materno, bit_psicologo, bit_activo FROM usuarios order by primer_nombre, apellido_paterno, apellido_materno";

    $respuesta = mysqli_query($conexion, $sql);

    $sqlGetEstatusName = "SELECT * FROM estatus_paciente";
    $respuestaGetNombreEstatus = mysqli_query($conexion, $sqlGetEstatusName);
    
?>
<form id="frmEditarPaciente" method="POST" onSubmit="return editarPaciente()">
    <div class="modal fade" id="modalEditarPaciente" tabindex="-1" role="dialog" aria-labelledby="modalEditarPaciente" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" name="idPacienteEditar" id="idPacienteEditar" value="">    
                    <h5 class="modal-title" id="exampleModalLabel">Editar Paciente</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="primer_nombreu">Primer Nombre</label>
                            <input type="text" class="form-control" id="primer_nombreu" name="primer_nombreu" placeholder="Nombre" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="segundo_nombreu">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundo_nombreu" name="segundo_nombreu" placeholder="Segundo Nombre">
                        </div>
                        <div class="col-sm-4">
                            <label for="apellido_paternou">Apellido Paterno</label>
                            <input type="text" class="form-control" id="apellido_paternou" name="apellido_paternou" placeholder="Apellido" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="apellido_maternou">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellido_maternou" name="apellido_maternou" placeholder="Apellido Materno">
                        </div>
                        <div class="col-sm-4">
                            <label for="fecha_nacimientou">Fecha Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimientou" id="fecha_nacimientou" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="sexou">Sexo</label>
                            <select class="form-control" id="sexou" name="sexou" placeholder="Sexo" required>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="telefonou">Telefono</label>
                            <input type="text" class="form-control" id="telefonou" name="telefonou" placeholder="Telefono" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="correou">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correou" name="correou" placeholder="Correo">
                        </div>
                        <div class="col-sm-4">
                            <label for="psicologo_encargadou">Asignar Piscólogo</label>
                            <select class="form-control form-select" name="psicologo_encargadou" id="psicologo_encargadou" required>
                                <?php
                                    while($datosPsicologo = mysqli_fetch_array($respuesta)){
                                        if($_SESSION['usuario']['id'] == 1 && $datosPsicologo['bit_psicologo'] == 1 && $datosPsicologo['bit_activo'] == 1){
                                ?>
                                    <option value="<?php echo $datosPsicologo['id_usuario']; ?>"> 
                                        <?php echo $datosPsicologo['primer_nombre'];?> <?php echo $datosPsicologo['apellido_paterno'];?> <?php echo $datosPsicologo['apellido_materno'];?>
                                    </option>
                                <?php   
                                    }elseif($_SESSION['usuario']['id'] == $datosPsicologo['id_usuario'] && $datosPsicologo['bit_psicologo'] == 1 && $datosPsicologo['bit_activo'] == 1){
                                ?>
                                    <option value="<?php echo $datosPsicologo['id_usuario']; ?>"> 
                                        <?php echo $datosPsicologo['primer_nombre'];?> <?php echo $datosPsicologo['apellido_paterno'];?> <?php echo $datosPsicologo['apellido_materno'];?>
                                    </option>
                                <?php 
                                    }                                  
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4">
                            <label for="estatus_paciente">Estatus del paciente</label>
                            <select class="form-control form-select" name="estatus_paciente" id="estatus_paciente">
                                <?php
                                    while($mostrar = mysqli_fetch_array($respuestaGetNombreEstatus)){
                                    ?>
                                    <option value="<?php echo $mostrar['id_estatus'];?>"><?php echo $mostrar['descripcion'];?></option>    
                                    <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <span class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</span> <!--se pone span por el onSubmit, si se da clic en cerrar tambien se guardaria el paciente-->
                    <button class="btn btn-outline-primary">Guardar Datos</button>
                </div>

            </div>
        </div>
    </div>
</form>