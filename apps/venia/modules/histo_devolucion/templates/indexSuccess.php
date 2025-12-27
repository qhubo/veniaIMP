<script src='/assets/global/plugins/jquery.min.js'></script>
<?php include_partial('soporte/labels') ?>  


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Devoluciones <small>..</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>

    <div class="kt-portlet__body">

        <?php $modulo = $sf_params->get('module'); ?>
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row" style="padding-bottom:30px">
            <div class="col-lg-2">Seleccione el rango de fecha</div>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2 <?php if ($form['medio_pago']->hasError()) echo "has-error" ?>">
                <?php echo $form['medio_pago'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['medio_pago']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2 <?php if ($form['vendedor']->hasError()) echo "has-error" ?>">
                <?php echo $form['vendedor'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['vendedor']->renderError() ?>  
                </span>
            </div>
        </div>
        <?php echo "</form>"; ?>

        <div class="row">
            <div class="col-lg-12">

                <div class="row">
                    <div class="col-lg-8">
                        <h3>Devoluciones Por Vendedor  <?php if ($medio_pago) { ?>
                                [<?php echo $medio_pago; ?>]
                            <?php } ?> 
                        </h3>
                        <?php include_partial('histo_devolucion/graficaVenta', array('vendedor' => $vendedor, 'medio_pago' => $medio_pago, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin)) ?>  
                    </div>
                    <div class="col-lg-4">
                        <?php include_partial('histo_devolucion/resumenVenta', array('vendedor' => $vendedor, 'medio_pago' => $medio_pago, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin)) ?>  


                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
   <div class="row">
       <div class="col-lg-4">
                   <?php include_partial('histo_devolucion/resumenMotivo', array('vendedor' => $vendedor, 'medio_pago' => $medio_pago, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin)) ?>  
 
           
       </div>
       <div class="col-lg-8">
                <h3>Devoluciones Por Motivo
                    <?php if ($vendedor) { ?>
                        [<?php echo $vendedor; ?>]
                    <?php } ?> 
                </h3>
                <?php include_partial('histo_devolucion/graficaMotivo', array('vendedor' => $vendedor, 'medio_pago' => $medio_pago, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin)) ?>  
           
       </div>
   </div>     
                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h3>Histórico Devoluciones</h3>
                <?php include_partial('inicio/grafica', array('vendedor' => $vendedor, 'medio_pago' => $medio_pago, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin)) ?>  

            </div>

            <div class="col-lg-6">
                <h3>Ultimas Devoluciones</h3>
                <?php include_partial('inicio/grafica2', array('vendedor' => $vendedor, 'medio_pago' => $medio_pago, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin)) ?>  
            </div> 
        </div>

    </div>
</div>