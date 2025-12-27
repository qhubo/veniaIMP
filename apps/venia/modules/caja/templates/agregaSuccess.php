   

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
              Agrega Servicio
                <small>  &nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
          </div>
    </div>
    <div class="kt-portlet__body">
<table class="table table-striped- table-bordered  "  width="100%">
                            <tr>
                                <th  align="center"><font size="-1">  Nombre</font></th>
                                <th  align="center"> <font size="-1">Frecuencia </font></th>
                                <th  align="center"><font size="-1">Tipo Servicio </font></th>
                                <th  align="center"><font size="-1"> Cuotas </font></th>
                            </tr>
                            <?php foreach ($servicios as $data) { ?>
                                <tr>
                                    <td><font size="-1"><?php echo $data->getNombre() ?></font> </td>
                                    <td><font size="-1"><?php echo $data->getFrecuencia() ?></font></td>
                                    <td><font size="-1"><?php echo $data->getTipoServicio() ?></font></td>
                                    <td><font size="-1"><?php echo $data->getCuotasDes() ?></font></td>
                                    <td align="center">
                                     <a class="btn  btn-info"  href="<?php echo url_for('caja/agregaSer?id=' . $data->getId()) ?>" ><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;&nbsp;</a>  
                          
                                    </td>
                                </tr>
                            <?php } ?>

                        </table>
        
    </div>
    <div class="modal-footer">
                             
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                            </div>
</div>