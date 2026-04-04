
<div class="row">
    <div class="col-lg-2"><br></div>

</div>

<div class="row">
    <div class="col-lg-6" style="background-size: contain; color:white; background-image: url(./assets/media//bg/300.jpg); padding-top: 6px; padding-bottom: 6px">Ingresa un abono y/o pago [ <?php echo $operacion->getClienteId(); ?> ]</div>
    <div class="col-lg-2" style="text-align:right" ><strong> Valor Total</strong></div>
    <div class="col-lg-4">
        <input class="form-control"   style=" background-color:#F9FBFE" readonly="true" value="<?php echo Parametro::formato($operacion->getValorTotal(),false); ?> " >
    </div>
</div>

<div class="row">
    <div class="col-lg-5" ></div>
    <div class="col-lg-3" style="text-align:right"><strong> Valor Pagado</strong></div>
    <div class="col-lg-4">
        <input class="form-control"  style=" background-color:#F9FBFE" readonly="true" value="<?php echo Parametro::formato($operacion->getValorPagado(),false); ?> " >
    </div>
</div>

<div class="row">
    <div class="col-lg-5" ></div>
    <div class="col-lg-3" style="text-align:right"><strong> Saldo</strong></div>
    <div class="col-lg-4">
        <input type="hidden" id="deuda_total" value="<?php echo ($operacion->getValorTotal()-$operacion->getValorPagado()); ?>">
        <input class="form-control"  style=" background-color:#F9FBFE; color:black;"  readonly="true" value="<?php echo Parametro::formato($operacion->getValorTotal()-$operacion->getValorPagado(),false); ?> " >
    </div>
</div>

<div class="row">
    <div class="col-lg-12"><br></div>
</div>

<?php $saldo = $operacion->getValorTotal()-$operacion->getValorPagado()-$operacion->getVuelto(); ?>
<?php if ($saldo) { ?> 
<?php echo $form->renderFormTag(url_for('cuenta_por_cobrar/caja?id=' . $operacion->getId()), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>    
<div class="row" style="padding-top:3px;  padding-bottom:3px;  ">
    <div class="col-lg-3 labelvuelto" style="font-weight: bold; background-color:#F5F5F5" id="labelvuelto">Vuelto </div> 
    <div style="background-color:#DEF4FA panelvuelto" id="panelvuelto"  class="col-lg-5   <?php if ($form['vuelto']->hasError()) echo "has-error" ?>">
        <?php echo $form['vuelto']; ?>
        <span class="help-block form-error"> 
            <?php echo $form['vuelto']->renderError() ?>       
        </span>
    </div>
</div>
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
<div id="contenedor_documento">
    <textarea rows="2" cols="30" class="form-control"
        name="consulta[no_documento]" 
        id="consulta_no_documento"></textarea>
</div>


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
</div>



<?php  //if ($operacion->getCliente()->getCodigo()=='CONTRAENTREGA') { ?>  
<div class="row" style="padding-top:3px; padding-bottom:3px;  ">
    <div class="col-lg-3 labelcomi" style="font-weight: bold;background-color:#DEE0E0; " id="labelcomi">Valor Comisión </div> 
    
    <div style="background-color:#DEE0E0; " id="panelcomi" class="col-lg-5 panelcomi   <?php if ($form['comision']->hasError()) echo "has-error" ?>">
        <?php echo $form['comision'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['comision']->renderError() ?>       
        </span>
    </div>
</div>
<?php //} ?>
<div class="row" style="padding-top:3px;">
    <div class="col-lg-3">Valor </div> 
    <div class="col-lg-5   <?php if ($form['valor']->hasError()) echo "has-error" ?>">
       
<!--<input type="number" class="form-control" placeholder="0.00" any="step" step="any" name="consulta[valor]" id="consulta_valor" >-->
        <div style="position: relative;">
    <input type="number" name="consulta[valor]" placeholder="0.00" any="step" step="any" id="consulta_valor"  class="form-control">
    <span id="icono_bloqueo" style="position:absolute; right:10px; top:8px; display:none;">
        🔒
    </span>
</div>
 <?php //echo $form['valor'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['valor']->renderError() ?>       
        </span>
    </div>
    <div class="col-lg-3">
        <button class="btn btn-primary " type="submit">
            <i class="flaticon2-plus-1"></i>  Aceptar 
        </button>
    </div>


</div>


<?php echo '</form>' ?>
<?php  } else  { ?>
<div class="row" style="text-align:center">
    <div class="col-lg-12">
        <h3>Factura Pagada</h3>
    </div>
</div>


<?php } ?>






<script src='/assets/global/plugins/jquery.min.js'></script>
<?php if ($operacion) { ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_valor").on('change', function () {
            var id = <?php echo $operacion->getId(); ?>;
            var val = $("#consulta_valor").val();
            $.get('<?php echo url_for("cuenta_por_cobrar/vuelto") ?>', {id: id, val:val}, function (response) {
              $("#consulta_vuelto").val(response);
            });
        });
    });
</script>
<?php } ?>


<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_nit").on('change', function () {
            var id = <?php echo $operacion->getId(); ?>;
            var val = $("#consulta_nit").val();
            $.get('<?php echo url_for("lista_cobro/nit") ?>', {id: id, val:val}, function (response) {
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_nombre").on('change', function () {
            var id = <?php echo $operacion->getId(); ?>;
            var val = $("#consulta_nombre").val();
            $.get('<?php echo url_for("lista_cobro/nombre") ?>', {id: id, val:val}, function (response) {
               
            });

        });

    });
</script>
