<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-add-label-button kt-font-warning"></i>

                <h3 class="kt-portlet__head-title kt-font-info">
                    DETALLE DE SALIDA DE PRODUCTOS<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </small>
                </h3>
        </div>
        <div class="kt-portlet__head-toolbar">  
            <a href="<?php echo url_for($modulo.'/index') ?>" class="btn btn-small btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
                       <a target="_blank" href="<?php echo url_for($modulo.'/reportePdf?id=' . $id) ?>" class="btn  btn-small btn-warning " target = "_blank">
                   <li class="fa fa-print"></li> Reporte      
                       </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
        <table class="table table-bordered  no-footer dtr-inlin " width="100%">
            <thead >
                <tr class="active">
                    <th  align="center"> Fecha</th>
                    <th  align="center">Salida </th>
                    <th  align="center">Codigo </th>
                    <th  align="center">Producto </th>
                    <th  align="center">Ubicacion </th>
                    <th  align="center"> Cantidad </th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $regis) { ?>
                    <tr>
                        <td><?php echo $regis->getSalidaProducto()->getFechaDocumento(); ?></td>
                        <td><?php echo $regis->getSalidaProducto()->getCodigo(); ?></td>
                        <td><?php echo $regis->getProducto()->getCodigoSku(); ?></td>
                        <td><?php echo $regis->getProducto()->getNombre(); ?></td>
                        <td><?php echo $regis->getUbicacionId(); ?></td>
                        <td style="text-align: right;"><?php echo $regis->getCantidad(); ?></td>
                      
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<?php foreach ($productos as $regis) { ?>
 <div class="modal fade" id="ajaxmodalC<?php echo $regis->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Retornar Producto Inventario </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-top:10px">
                        <div class="col-lg-2 kt-font-info " style="font-weight:bold;">Codigo</div>
                        <div class="col-lg-8"><?php echo $regis->getProducto()->getCodigoSku(); ?> </div>
                    </div>
                    <div class="row" style="padding-top:10px">
                        <div class="col-lg-2 kt-font-info " style="font-weight:bold;">Producto</div>
                        <div class="col-lg-8" style="font-weight:bold;"><?php echo $regis->getProducto()->getNombre(); ?> </div>
                    </div>
                         <div class="row"  style="padding-top:10px">
                       <div class="col-lg-4 kt-font-info"  style="font-weight:bold;">Cantidad Transito</div>
                        <div class="col-lg-4"><?php echo $regis->getCantidad(); ?> </div>
                    </div>
                    
                        <div class="row"  style="padding-top:10px">
                       <div class="col-lg-4 kt-font-info"  style="font-weight:bold;">Cantidad Retornar</div>
                        <div class="col-lg-4">
                        <input class="form-control cantidad" value="" type="number" max="<?php echo $regis->getCantidad(); ?>" min="1" name="ubica119" id="ubica119">
                        </div>
                    </div>
                </div> 

                <div class="modal-footer">
                    <a class="btn  btn-success " href="" >
                        <i class="fa fa-trash-o "></i> Confirmar</a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>




       <script>
    const inputs = document.querySelectorAll('.cantidad');

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        const max = Number(input.getAttribute('max'));
        const min = Number(input.getAttribute('min'));
        let valor = Number(input.value);

        if (valor > max) {
          input.value = max; // Forzar el valor máximo
        } else if (valor < min) {
          input.value = min; // Evitar valores negativos
        }
      });
    });
  </script>