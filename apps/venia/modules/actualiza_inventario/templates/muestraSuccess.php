<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')  ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-1 kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Resultado <small>   detalle del ingreso      </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            
                        <a target="_blank" href="<?php echo url_for($modulo.'/reportePdf?id=' . $cabecera->getId()) ?>" class="btn  btn-small btn-warning " target = "_blank">
                   <li class="fa fa-print"></li> Reporte      
                       </a>
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
      <div class="kt-portlet__body">
             <div class="row">
            <div class="col-lg-1"> </div>    
            <div class="col-lg-2 kt-font-brand">Usuario </div>    
            <div class="col-lg-3"><?php echo $cabecera->getUsuario(); ?> </div>    
            <div class="col-lg-1"> </div>    

            <div class="col-lg-2 kt-font-brand">Fecha </div>    
            <div class="col-lg-2"><?php echo $cabecera->getFecha('d/m/Y H:i'); ?> </div>    
   
             </div>
           
          
        <div class="table-scrollable">
            <table class="table table-bordered  dataTable table-condensed flip-content" id="sample_2">
                <thead class="flip-content">
                    <tr class="active">
                        <th align="center" width="35px"></th>
                        <th  align="center"> Código Sku</th>
                        <th  align="center"> Nombre</th>
                        <th  align="center">Descripción </th>
                        <th  align="right">Ingresados </th>
                        <th  align="right"><?php echo $cabecera->getTienda(); ?> </th>

                        <th  align="right">Existencia Total </th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $data) { ?>
                    <?php $lista = $data->getProducto(); ?>
                        <tr  <?php if (!$lista->getActivo()) { ?> class="warning" <?php } ?> >

                            <td>  <img width="75px" src="<?php echo $lista->getImagen() ?>" ></td>
                            <td><?php echo $lista->getCodigoSku() ?> </td>
                            <td><?php echo $lista->getNombre() ?></td>
                             <td><font size="-1"> <?php echo $lista->getTipoAparato(); ?></font></td>
                            <td align="right">
                                <font size="-1"> <?php echo $data->getCantidad(); ?></font>  
                            </td>
                            <td  align="right">  <?php echo $lista->getExistenciaBodega($data->getIngresoProducto()->getTiendaId()) ?></td>
                            <td  align="right"><?php echo $lista->getExistencia() ?> </td>

                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

</div>

