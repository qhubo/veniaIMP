
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-edit kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Solicitud de Traslado de Producto  <small>  &nbsp;&nbsp;&nbsp;&nbsp;</small>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
         <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
     </div>
    </div>
    <div class="kt-portlet__body">

        <div class="row">
            <div class="col-lg-12"> 
                <table class="table  table-bordered "  >
                    <tr>
                        <th>Grupo</th>
                        <td><?php echo $producto->getTipoAparato()->getDescripcion(); ?> </td>
                        <th> </th>
                        <th> </th>
                    </tr>
                    <tr>
                        <th>Código</th>
                        <td><?php echo $producto->getCodigoSku(); ?> </td>
                        <th>Nombre</th>
                        <td><?php echo $producto->getNombre(); ?> </td>
                    </tr>
                </table> 
            </div>
        </div>    



        <div class="row">
            <div class="col-lg-4">
                <?php foreach ($tiendas as $data) { ?>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-6"><?php echo $data->getNombre(); ?> </div>
                        <div class="col-lg-2" style="font-size: 16px; text-align: right;"><?php echo $producto->getExistenciaBodega($data->getId()); ?> </div>
                    </div>
                    <hr>
                <?php } ?>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-6" style="text-align: right; font-weight: bold; font-size: 17px;" >Existencia Total</div>
                    <div class="col-lg-2" style="font-size: 16px; text-align: right;"><?php echo $producto->getExistencia(); ?> </div>
                </div>
                <hr>

            </div>
            <div class="col-lg-8">
                <?php echo $form->renderFormTag(url_for('traslado/traslada?id=' . $id), array('class' => 'form')) ?>
                <?php echo $form->renderHiddenFields() ?>
<?php echo $form['producto_id']; ?>

                <div style="width: 100%; text-align: center; font-size: 18px;">Detalle de traslado </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2" style="font-weight: bold;">Bodega Origen</div>
                    <div class="col-lg-6  <?php if ($form['bodega_origen']->hasError()) echo "has-error" ?>" ><?php echo $form['bodega_origen']; ?>
                    
                    <span class="help-block form-error" style="font-size:12px;"> 
                    <?php echo $form['bodega_origen']->renderError() ?>  
                </span>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px;">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2" style="font-weight: bold;">Bodega Destinto</div>
                    <div class="col-lg-6  <?php if ($form['bodega_destino']->hasError()) echo "has-error" ?>" ?>
                          <?php echo $form['bodega_destino']; ?>
                        <span class="help-block form-error" style="font-size:12px;"> 
                    <?php echo $form['bodega_destino']->renderError() ?>  
                </span>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px;">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2" style="font-weight: bold;">Motivo</div>
                    <div class="col-lg-6  <?php if ($form['comentario']->hasError()) echo "has-error" ?>" >
                        <?php echo $form['comentario']; ?>
                     <span class="help-block form-error" style="font-size:12px;">> 
                    <?php echo $form['comentario']->renderError() ?>  
                </span>
                    </div>
                </div>    
                <div class="row" style="padding-top: 5px;">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2" style="font-weight: bold;">Cantidad</div>
                    <div class="col-lg-3 <?php if ($form['cantidad']->hasError()) echo "has-error" ?>" ><?php echo $form['cantidad']; ?>
                    
                     <span class="help-block form-error"> 
                    <?php echo $form['cantidad']->renderError() ?>  
                </span>
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-primary " type="submit">
                            <i class="flaticon-mark "></i>
                            Solicitar Traslado
                        </button>
                    </div>
                </div>
                    <?php echo '</form>'; ?>
            </div>

        </div>
    </div>

