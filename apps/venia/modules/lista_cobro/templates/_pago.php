
<div class="row">
    <div class="col-lg-2"><br></div>

</div>

<div class="row">
    <div class="col-lg-6" style="background-size: contain; color:white; background-image: url(./assets/media//bg/300.jpg); padding-top: 6px; padding-bottom: 6px">Ingresa un abono y/o pago</div>
    <div class="col-lg-2" style="text-align:right" ><strong> Valor Total</strong></div>
    <div class="col-lg-4">
        <input class="form-control"  background-color="#F9FBFE" readonly="true" value="<?php echo Parametro::formato($operacion->getValorTotal(),false); ?> " >
    </div>
</div>

<div class="row">
    <div class="col-lg-5" ></div>
    <div class="col-lg-3" style="text-align:right"><strong> Valor Pagado</strong></div>
    <div class="col-lg-4">
        <input class="form-control"  background-color="#F9FBFE" readonly="true" value="<?php echo Parametro::formato($operacion->getValorPagado(),false); ?> " >
    </div>
</div>

<div class="row">
    <div class="col-lg-5" ></div>
    <div class="col-lg-3" style="text-align:right"><strong> Saldo</strong></div>
    <div class="col-lg-4">
        <input class="form-control"  background-color="#F9FBFE" readonly="true" value="<?php echo Parametro::formato($operacion->getValorTotal()-$operacion->getValorPagado(),false); ?> " >
    </div>
</div>



<div class="row">
    <div class="col-lg-12"><br></div>

</div>

<?php $saldo = $operacion->getValorTotal()-$operacion->getValorPagado(); ?>
<?php if ($saldo) { ?> 
<?php echo $form->renderFormTag(url_for('lista_cobro/caja?id=' . $operacion->getId()), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>    

<div class="row">
    <div class="col-lg-3">Tipo Pago </div>
    <div class="col-lg-6   <?php if ($form['tipo_pago']->hasError()) echo "has-error" ?>">
        <font size ="-1">  </font>
        <?php echo $form['tipo_pago'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['tipo_pago']->renderError() ?>       
        </span>


    </div>
</div>
<div class="row">               
    <div class="col-lg-3">Documento </div>
    <div class="col-lg-6   <?php if ($form['no_documento']->hasError()) echo "has-error" ?>">
        <font size ="-1"> </font>                           
        <?php echo $form['no_documento'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['no_documento']->renderError() ?>       
        </span>


    </div>
</div>

<div class="row">               
    <div class="col-lg-3">Banco </div>
    <div class="col-lg-6   <?php if ($form['banco_id']->hasError()) echo "has-error" ?>">
        <font size ="-1"> </font>                           
        <?php echo $form['banco_id'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['banco_id']->renderError() ?>       
        </span>


    </div>
</div>
<div class="row">
    <div class="col-lg-3">Fecha Documento </div> 
    <div class="col-lg-6   <?php if ($form['fecha']->hasError()) echo "has-error" ?>">

        <font size ="-1">  </font>
        <?php echo $form['fecha'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['fecha']->renderError() ?>       
        </span>


    </div>
</div>
<!--<div class="row">
    <div class="col-lg-3">Factura Fel </div> 
    <div class="col-lg-6   <?php if ($form['factura_electronica']->hasError()) echo "has-error" ?>">

        <font size ="-1">  </font>
        <?php echo $form['factura_electronica'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['factura_electronica']->renderError() ?>       
        </span>


    </div>
</div>-->


<div class="row">
    <div class="col-lg-12">
        <br>

    </div>
</div>
<div class="row">
    <div class="col-lg-3">Valor </div> 
    <div class="col-lg-5   <?php if ($form['valor']->hasError()) echo "has-error" ?>">

        <font size ="-1">  </font>
        <?php echo $form['valor'] ?>          
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
