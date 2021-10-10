<?php
    include "../clases/Conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
    $sql="SELECT id_usuario, primer_nombre, apellido_paterno, apellido_materno, bit_psicologo, bit_activo FROM usuarios order by primer_nombre, apellido_paterno, apellido_materno";

    $respuesta = mysqli_query($conexion, $sql);
    
?>
<form id="frmAgregarPaciente" method="POST" onSubmit="return agregarNuevoPaciente()">
    <div class="modal fade" id="modalAgregarPacientes" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPacientes" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo paciente</h5>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="primer_nombre">Primer Nombre(*)</label>
                            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" placeholder="Nombre" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="segundo_nombre">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" placeholder="Segundo Nombre">
                        </div>
                        <div class="col-sm-4">
                            <label for="apellido_paterno">Apellido Paterno(*)</label>
                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno">
                        </div>
                        <div class="col-sm-4">
                            <label for="fecha_nacimiento">Fecha Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
                        </div>
                        <div class="col-sm-4">
                            <label for="sexo">Sexo(*)</label>
                            <select class="form-control" id="sexo" name="sexo" placeholder="Sexo" required>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="telefono">Telefono(*)</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo">
                        </div>
                        <div class="col-sm-4">
                            <label for="psicologo_encargado">Asignar Piscólogo(*)</label>
                            <select class="form-control" name="psicologo_encargado" id="psicologo_encargado" required>
                                <option value="">Seleccione al psicólogo</option>
                                <?php
                                    while($datosPsicologo = mysqli_fetch_array($respuesta)){
                                        if($_SESSION['usuario']['rol'] == 1 && $datosPsicologo['bit_psicologo'] == 1 && $datosPsicologo['bit_activo'] == 1){                                           
                                ?>
                                    <option value=" <?php echo $datosPsicologo['id_usuario']; ?> "> 
                                        <?php echo $datosPsicologo['primer_nombre'];?> <?php echo $datosPsicologo['apellido_paterno'];?> <?php echo $datosPsicologo['apellido_materno'];?>
                                    </option>
                                <?php
                                    }elseif($_SESSION['usuario']['id'] == $datosPsicologo['id_usuario'] && $datosPsicologo['bit_psicologo'] == 1 && $datosPsicologo['bit_activo'] == 1){
                                    ?>
                                        <option value=" <?php echo $datosPsicologo['id_usuario']; ?> "> 
                                            <?php echo $datosPsicologo['primer_nombre'];?> <?php echo $datosPsicologo['apellido_paterno'];?> <?php echo $datosPsicologo['apellido_materno'];?>
                                        </option>
                                    <?php
                                    }                              
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <h7 style="color: red; font-size: 14px;">Los campos marcados con (*) son obligatorios.</h7>
                </div>

                <div class="modal-footer">
                    <span class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</span> <!--se pone span por el onSubmit, si se da clic en cerrar tambien se guardaria el paciente-->
                    <button class="btn btn-outline-primary">Guardar Datos</button>
                </div>

            </div>
        </div>
    </div>
</form>
