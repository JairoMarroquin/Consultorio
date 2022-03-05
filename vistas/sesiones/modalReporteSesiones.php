<form method="POST" id ="frmReporteSesiones" action="../procesos/sesiones/reporteSesiones.php">
    <div class="modal fade" id="modalReporteSesion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Descargar reporte de Sesiones</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="dia_inicial">Desde</label>
                            <input type="date" id="dia_inicial" name="dia_inicial" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="dia_final">Hasta</label>
                            <input type="date" id="dia_final" name="dia_final" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</span>
                    <input type="submit" name="generar_reporte" class="btn btn-outline-success"></input>
                </div>
            </div>
        </div>
    </div>
</form>