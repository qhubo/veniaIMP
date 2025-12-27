<?php $valor = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), '', 'seguridad'); ?>
<?php $ValorBanco = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'conciliado'); ?>
<?php $retorna = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'diferencia'); ?>
<?php if ($banco->getHsaldoBanco() <> "") { ?>
<?php $valor = $banco->getHsaldoBanco(); ?>
    <?php } ?>

<?php if ($banco->getHsaldoConciliado() <> "") { ?>
<?php $ValorBanco = $banco->getHsaldoConciliado(); ?>
    <?php } ?>

<?php if ($banco->getHDiferencia() <> "") { ?>
<?php $retorna = $banco->getHDiferencia(); ?>
    <?php } ?>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">
            <thead>
                <tr class="active">
                    <th  style="text-align: left; padding-left: 40px">Banco</th>
                    <td  ><?php echo $banco->getNombre(); ?> </td>
                </tr>
                <tr class="active">
                    <th  style="text-align: left; padding-left: 40px">Saldo en  Libros</th>
                    <td   onkeypress="validate(event)"  style="text-align: right; padding-right: 40px"><?php echo Parametro::formato($banco->getSaldoLibros()); ?> </td>

                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-2"></div>    
    <div class="col-lg-8">
        <table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">
            <thead>
            <input type='hidden' readonly="true" class="form-control" value="<?php echo Parametro::formato($banco->getSaldoTransito(), false); ?> " style="background-color:#F9FBFE ;"  name="totalconfirma" id="totalconfirma"> 

            <tr class="active">
                <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px">Saldo&nbsp;en&nbsp;Bancos</th>
                <td style="text-align: right; padding-right: 10px"> <input onkeypress="validate(event)"  class="form-control" placeholder="0.00"  <?php if ($valor) { ?> value="<?php echo $valor; ?>" <?php } ?>  name="totalbanco" id="totalbanco"> </td>
            </tr>

            </thead>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <?php include_partial('concilia_banco/transito', array('banco' => $banco)) ?>  
    </div>

</div>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">
            <thead>
                <tr class="active">
                    <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px">Saldo Conciliado</th>
                    <td style="text-align: right; padding-right: 10px"> <input  readOnly="true" class="form-control"    name="totalconcilia" id="totalconcilia" <?php if ($ValorBanco) { ?> value="<?php echo $ValorBanco ?>"  <?php } else { ?> value="<?php echo $banco->getSaldoTransitoBanco(); ?>" <?php } ?> > </td>
                </tr>

                <tr class="active">
                    <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px">Diferencia</th>
                    <td style="text-align: right; padding-right: 10px"> 

                        <input class="form-control"  type="text" readOnly="true"  style="background-color:#F9FBFE ;"  name="totaldiferencia" id="totaldiferencia"   value="<?php echo $retorna; ?>"    > 

                    </td>

                </tr>
            </thead>
        </table>
    </div>

</div>




<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-2">
        <a target="_blank" href="<?php echo url_for('reporte/conciliaBanco?bancoId=' . $banco->getId()) ?>" class="btn  btn-sm btn-secondary btn-info btn-block" > <i class="flaticon2-printer"></i> Pdf </a>

    </div>
    <div class="col-md-2">    
        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>
    </div>
</div>

<script>
    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);

        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }
    }
</script>


<script src='/assets/global/plugins/jquery.min.js'></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#totalbanco").on('change', function () {
            var id = $("#totalbanco").val();
            var idv = <?php echo $banco->getId(); ?>;
            $.get('<?php echo url_for("concilia_banco/concilia") ?>', {id: id, idv: idv}, function (response) {
                var respuestali = response;
                var arr = respuestali.split('|');
                var conciliado = arr[0];
                var diferencia = arr[1];
                $("#totalconcilia").val(conciliado);
                $("#totaldiferencia").val(diferencia);
            });

        });

    });
</script>