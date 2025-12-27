        <?php $modulo = $sf_params->get('module'); ?> 
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> REPORTE KARDEX PRODUCTO
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        <div class="actions"> <a class="btn  btn grey-cascade  btn-block "  target="_blank"  href="<?php echo url_for($modulo . '/reporte') ?>" ><i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;  <i class="fa fa-print"></i></a></div>

        </div>
    </div>
    <div class="kt-portlet__body">

        <?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        
              <div class="row" style="padding-top:5px;">
                    <label class="col-lg-1 control-label right ">Nombre  </label>
            <div class="col-lg-4 <?php if ($form['nombrebuscar']->hasError()) echo "has-error" ?>">
                <?php echo $form['nombrebuscar'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombrebuscar']->renderError() ?>  
                </span>
            </div>
            
        </div>
        
        
           <div class="row" style="padding-top:5px;">
          
            <label class="col-lg-1 control-label right "><span class="font-blue bold Bold"> Fecha Inicio </span>  </label>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <label class="col-lg-1 control-label right "><span class="font-blue bold Bold">Fecha Fin</span>  </label>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
                   <label class="col-lg-1 control-label right ">Bodega  </label>
            <div class="col-lg-4 <?php if ($form['bodega']->hasError()) echo "has-error" ?>">
                <?php echo $form['bodega'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['bodega']->renderError() ?>  
                </span>
            </div>
        
        </div>



        <div class="row" style="padding-top:5px; padding-bottom: 10px">
    
     
            <label class="col-lg-1 control-label right ">Motivo  </label>
            <div class="col-lg-2 <?php if ($form['motivo']->hasError()) echo "has-error" ?>">
                <?php echo $form['motivo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['motivo']->renderError() ?>  
                </span>
            </div>
                 <label class="col-lg-1 control-label right ">Tipo </label>
            <div class="col-lg-2 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
        
    
            <div class="col-lg-2">
                <?php echo $form['transito'] ?> 

            </div>
               <div class="col-lg-2">
                <button class="btn  btn-sm  btn-success " type="submit">
                    <i class="fa fa-search "></i> Consultar
                </button>
            </div>

        </div>
  
        



        <?php echo '</form>'; ?>


        <div class="table-scrollable">
            <table class="table table-bordered  dataTable table-condensed flip-content" >
                <thead class="flip-content">
                    <tr class="info">
                        <th  align="center">Código</th>
                        <th  align="center">Operación</th>                               
                        <th  align="center">Referencia</th>     
                        <th  align="center">Descripción</th>
                        <th  align="center">Fecha</th>   
                        <th  align="center">Bodega</th>
                        <th  align="center">Motivo</th>    
                        <th  align="center">Producto</th>
                        <th  align="center">Inicial </th>   
                        <th  align="center">Tipo</th>          
                        <th  align="center">Entrada</th>   
                        <th  align="center">Salida</th>   
                        <th  align="center">Final</th>   
                        <th  align="center">Venta</th>   
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimiento as $reg) { ?>
                        <tr <?php if ($reg->getMotivo() == 'Reinicio Inventario') { ?> style="background-color:#FF1590" <?php } ?> >
                            <td><?php echo $reg->getProducto()->getCodigoSku(); ?></td>
                            <td><?php echo $reg->getTipoDocumento(); ?></td>
                            <td><?php echo $reg->getDocumento(); ?></td>                            
                            <td><?php echo $reg->getNombreDocumento(); ?></td>
                            <td><?php echo $reg->getFecha('d/m/Y H:i'); ?></td>
                            <td><?php echo $reg->getTienda(); ?></td>
                            <td><?php echo $reg->getMotivo(); ?></td>
                            <td><?php echo $reg->getProducto()->getNombre(); ?></td>
                            <td align="right" ><?php echo $reg->getInicio(); ?></td> 
                            <td><?php echo $reg->getTipo(); ?></td>
                            <td align="right" ><?php if (($reg->getTipo()=="INGRESO")  or ($reg->getTipo()=="TRANSITO INGRESO") or ($reg->getTipo()=="TRASLADO INGRESO") ) {   echo $reg->getCantidad(); } ?></td> 
                            <td align="right" ><?php if (($reg->getTipo() !="INGRESO")   && ($reg->getTipo()!="TRANSITO INGRESO")  && ($reg->getTipo()!="TRASLADO INGRESO") ) {  echo $reg->getCantidad(); } ?></td> 


                            <td align="right" ><?php echo $reg->getFin(); ?></td> 
                            <td align="right" ><?php echo Parametro::formato($reg->getVenta()); ?></td> 

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>