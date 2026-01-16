<?php $modulo = $sf_params->get('module'); ?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-green-sharp">

            <span class="caption-subject  font-green-sharp "></span>&nbsp;&nbsp;&nbsp;
            <span class="label  label-info uppercase "> </span>
        </div>
        <div class="inputs">

        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-lg-12" style="text-align: center"><h3>COSTO DE KARDEX</h3></div>
        </div>
        <div class="row">
                        <div class="col-lg-2">     
        </div>
            <div class="col-lg-10">
        <table class="table">
              <tr>
                <th>Fecha</th>
                <td><?php echo $registro->getFecha('d/m/Y'); ?></td>
            </tr>
            <tr>
                <th>Producto</th>
                <td><?php echo $registro->getProducto()->getCodigoSku(); ?> <?php echo $registro->getProducto()->getNombre(); ?></td>
            </tr>
             <tr>
                <th>Costo</th>
                
                <td>
                    
                    <?php if ($registro->getCosto() >0) { ?>
               <?php echo Parametro::formato($registro->getCosto()); ?>     
               <?php  } else { ?>
                    <?php //echo Parametro::formato($registro->getProducto()->getCostoProveedor()); ?>
                    <?php } ?>
                </td>
            </tr>
        </table> 
                
            </div>
       
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
        </div>  
    </div>
</div>