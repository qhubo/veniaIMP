<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-signs  kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Caja
                <small>  &nbsp;&nbsp;&nbsp;&nbsp; Procede a confirmar los pagos varios</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-bordered">
            <tr>
                <th>Factura</th>
                <th>Fecha</th>
                <th>Valor Pago</th>
            </tr>
            <?php foreach($lista as $reg) { ?>
            <tr>
                <td><?php echo $reg['codigo'] ?></td>
                <td><?php echo $reg['fecha'] ?></td>
                <td><?php echo Parametro::formato($reg['valor'],false) ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="2"> Valor TOTAL</td>
                <Th><?php echo Parametro::formato($total); ?></Th>
            </tr>
                
        </table>
        <form class="form-horizontal" action="<?php echo url_for('cuenta_por_cobrar/pagoMasiva') ?>?list=<?php echo $list; ?>"  method="post">
<?php echo $form->renderHiddenFields() ?> 
        <div class="row" style="padding-top:3px;">
    <div class="col-lg-3">Tipo Pago </div>
    <div class="col-lg-6   <?php if ($form['tipo_pago']->hasError()) echo "has-error" ?>">
        <font size ="-1">  </font>
        <?php echo $form['tipo_pago'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['tipo_pago']->renderError() ?>       
        </span>
    </div>
</div>
        
        <div class="row" style="padding-top:3px;">               
    <div class="col-lg-3">Documento </div>
    <div class="col-lg-6   <?php if ($form['no_documento']->hasError()) echo "has-error" ?>">
        <font size ="-1"> </font>                           
        <?php echo $form['no_documento'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['no_documento']->renderError() ?>       
        </span>
    </div>
</div>
<div class="row" style="padding-top:3px;">               
    <div class="col-lg-3">Banco </div>
    <div class="col-lg-6   <?php if ($form['banco_id']->hasError()) echo "has-error" ?>">
        <font size ="-1"> </font>                           
        <?php echo $form['banco_id'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['banco_id']->renderError() ?>       
        </span>
    </div>
</div>
<div class="row" style="padding-top:3px;">
    <div class="col-lg-3">Fecha Documento </div> 
    <div class="col-lg-6   <?php if ($form['fecha']->hasError()) echo "has-error" ?>">
        <?php echo $form['fecha'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['fecha']->renderError() ?>       
        </span>
    </div>
     <div class="col-lg-3">
        <button class="btn btn-primary " type="submit">
            <i class="flaticon2-plus-1"></i>  Aceptar 
        </button>
    </div>
    </div>
        </form>
</div>
    
    
      
</div>


