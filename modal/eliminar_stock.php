<form class="form-horizontal" method="post">
    <!-- Modal -->
    <div id="remove-stock" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Eliminar Stock</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="quantity" class="col-sm-2 control-label">Cantidad</label>
                        <div class="col-sm-6">
                            <input type="number" min="1" name="quantity_remove" class="form-control"
                                id="quantity_remove" value="" placeholder="Cantidad" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantity" class="col-sm-2 control-label">Motivo</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="motivo" id="motivo" required>
                                <option value>Elegir un motivo..</option>
                                <option value="1">1- Uso</option>
                                <option value="2">2- Dañado</option>
                                <option value="3">3- Devolucion</option>
                            </select>
                          
                        </div>
                    </div>
                   

                    <div class="form-group">
                        <label for="reference" class="col-sm-2 control-label">Codigo</label>
                        <div class="col-sm-6">
                            <input type="number" name="reference_remove" class="form-control" id="reference_remove"
                                value="<?php echo $row['codigo_producto'];?>" placeholder="Referencia" readonly>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar datos</button>
                </div>
            </div>

        </div>
    </div>
</form>