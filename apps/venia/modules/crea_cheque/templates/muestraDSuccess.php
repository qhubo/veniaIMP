<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')     ?>
<?php //$areglo= unserialize($areglo);         ?> 
<?php //$areglo = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'producto'));         ?>
<?php //echo  "<pre>";   print_r($areglo); die();          ?>
<?php $ocultavd = false; ?> 
<?php $grandTotal = $total; ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestraD?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Creación de Cheque   <small> Puede seleccionar pago del mismo banco y proveedor . Y agruparlo en un cheque</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>


    </div>

    <div class="kt-portlet__body">

        <div class="row">
            <div class="col-lg-7">
                <div class="table-scrollable">
                    <table class="table table-bordered  dataTable table-condensed flip-content" >
                        <thead >
                            <tr class="active">

                                <th  align="center"> <font >Cliente</font>  </th>
                                <th  align="center"> <font >Observaciones</font>  </th>
                                <th  width="75px" align="center"> <font >Valor</font>  </th>
                                <th  width="75px" align="center"> <font >Retenido</font>  </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td><?php echo $devolucion->getNombre(); ?></td><!-- comment -->
                                <td><?php echo $devolucion->getConcepto(); ?></td>
                                <td><div style="text-align: right"> <?php echo Parametro::formato($devolucion->getValor(), 2); ?></div> </td>
                                <td><div style="text-align: right"> <?php echo Parametro::formato($devolucion->getValorOtros(), 2); ?></div> </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-5">

                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">Banco</div>
                    <div class="col-lg-6 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
                        <?php echo $form['banco'] ?>           
                        <span class="help-block form-error"> 
                            <?php echo $form['banco']->renderError() ?>  
                        </span>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-lg-12"><br></div>
                </div>

                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">Formato</div>
                    <div class="col-lg-6 <?php if ($form['formato']->hasError()) echo "has-error" ?>">
                        <?php echo $form['formato'] ?>           
                        <span class="help-block form-error"> 
                            <?php echo $form['formato']->renderError() ?>  
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12"><br></div>
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">No Cheque.</div>

                    <div class="col-lg-4 <?php if ($form['cheque']->hasError()) echo "has-error" ?>">
                        <?php echo $form['cheque'] ?>           
                        <span class="help-block form-error"> 
                            <?php echo $form['cheque']->renderError() ?>  
                        </span>
                    </div>
                </div>




                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">Total</div>
                    <div class="col-lg-6" style="text-align: right" >
                        <div class="totalv" id ="totalv">    
                            <h3> <?php echo number_format($grandTotal, 2); ?> </h3> 
                        </div>

                    </div> 
                </div>

                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">No Negociable.</div>
                    <div class="col-lg-2 ">
                        <?php echo $form['no_negociable'] ?>   
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-block btn-primary " type="submit">
                            <i class="fa fa-save "></i>
                            Aceptar  
                        </button>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>


<?php echo '</form>'; ?>



<script>
    $(document).ready(function () {
        $("#consulta_banco").on('change', function () {
            $("#consulta_formato").empty();
            $.getJSON('<?php echo url_for("soporte/chequeFormato") ?>?id=' + $("#consulta_banco").val(), function (data) {
                console.log(JSON.stringify(data));
                $.each(data, function (k, v) {

                    if (k == "") {
                        $("#consulta_formato").append("<option selected='selected'  value=\"" + k + "\">" + v + "</option>");
                    } else {
                        $("#consulta_formato").append("<option value=\"" + k + "\">" + v + "</option>");
                    }

                }).removeAttr("disabled");
            });
            
              var id = $("#consulta_banco").val();
            $.get('<?php echo url_for("crea_cheque/correlativoBan") ?>', {id: id}, function (response) {
                $("#consulta_cheque").val(response);
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_formato").on('change', function () {
            var id = $("#consulta_formato").val();
            $.get('<?php echo url_for("crea_cheque/correlativo") ?>', {id: id}, function (response) {
                $("#consulta_cheque").val(response);
            });
        });
    });
</script>


<!--


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
-->
