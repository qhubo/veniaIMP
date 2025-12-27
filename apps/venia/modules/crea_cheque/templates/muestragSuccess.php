<?php $modulo = $sf_params->get('module'); ?>
<?php //include_partial('soporte/avisos')    ?>
<?php //$areglo= unserialize($areglo);        ?> 
<?php //$areglo = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'producto'));        ?>
<?php //echo  "<pre>";   print_r($areglo); die();         ?>
<?php $ocultavd = false; ?> 
<?php $grandTotal = $total; ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/muestrag?id=' . $id), array('class' => 'form-horizontal"')) ?>
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

                                <th  align="center"> <font >Proveedor</font>  </th>
                                <th  align="center"> <font >Nombre</font>  </th>
                                <th  width="75px" align="center"> <font ></font>  </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gastos as $registro) { ?>
                                <?php $lista = $registro; ?>
                                <?php $i = $registro->getId(); ?>
                                <?php if ($registro->getTemporal()) { ?>
                                    <?php $estiloDos = ''; ?>
                                    <?php $estiloUno = 'style="display:none;"'; ?>
                                <?php } else { ?>
                                    <?php $estiloUno = ''; ?>
                                    <?php $estiloDos = 'style="display:none;"'; ?>
                                <?php } ?>
                                <tr id="lin<?php echo $i ?>" class="lin<?php echo $i ?>"
                                <?php if ($registro->getTemporal()) { ?>
                                        style="background-color:#D7ECEA"
                                    <?php } ?>            
                                    >

                                    <td><?php echo $registro->getProveedor()->getCodigo(); ?></td><!-- comment -->
                                    <td><?php echo $registro->getProveedor()->getNombre(); ?></td>
                                    <td><div style="text-align: right"> <?php echo Parametro::formato($registro->getValorTotal(), 2); ?></div> </td>
                                    <td   width="75px">
                                        <div  id="btlista<?php echo $i ?>"  <?php echo $estiloUno ?> >
                                            <a id="activar<?php echo $i ?>" vivi="<?php echo $vivienda; ?>" dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/UnCheck.png"> </a>     
                                        </div> 
                                        <div  id="bNtactiva<?php echo $i ?>" <?php echo $estiloDos ?>>
                                            <a id="Nactivar<?php echo $i ?>"  vivi="<?php echo $vivienda; ?>"  dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/Check.png"></a> 
                                        </div>                   

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">Nombre Beneficiario</div>
                      <div class="col-lg-6 <?php if ($form['nombre_beneficiario']->hasError()) echo "has-error" ?>">
            <input class="form-control" type="text" name="consulta[nombre_beneficiario]" value="<?php echo $nombre; ?>"
                   <?php if (4==1) { ?> readonly="true" style="background-color:#F9FBFE ;" <?php  } ?>
                   id="consulta_nombre_beneficiario">          
                        <span class="help-block form-error"> 
                            <?php echo $form['nombre_beneficiario']->renderError() ?>  
                        </span>
                    </div>  
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





<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php if ($gastos) { ?>
    <?php foreach ($gastos as $registro) { ?>
        <?php $i = $registro->getId(); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#activar<?php echo $i ?>').click(function () {
                    var valorId = $(this).attr('dat');
                    var vivi = $(this).attr('vivi');
                    $.ajax({
                        type: 'GET',
                        url: '/index.php/crea_cheque/check',
                        data: {'id': valorId, 'vivi': vivi},
                        success: function (data) {
                            $('#totalv').html(data);
                        }
                    });
                    $('#activar0').hide();
                    $('#lin<?php echo $i ?>').css('background', '#D7ECEA');

                    $('#bNtactiva<?php echo $i ?>').slideToggle(250);
                    $('#btactiva<?php echo $i ?>').hide();
                    $('#bNtlista<?php echo $i ?>').slideToggle(250);
                    $('#btlista<?php echo $i ?>').hide();

                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#Nactivar<?php echo $i ?>').click(function () {
                    var valorId = $(this).attr('dat');
                    var vivi = $(this).attr('vivi');
                    $.ajax({
                        type: 'GET',
                        url: '/index.php/crea_cheque/uncheck',
                        data: {'id': valorId, 'vivi': vivi},
                        success: function (data) {
                            $('#totalv').html(data);
                        }
                    });
                    $('#lin<?php echo $i ?>').css('background', 'white');
                    $('#activar0').slideToggle(250);
                    $('#btactiva<?php echo $i ?>').slideToggle(250);
                    $('#bNtactiva<?php echo $i ?>').hide();
                    $('#btlista<?php echo $i ?>').slideToggle(250);
                    $('#bNtlista<?php echo $i ?>').hide();
                });
            });
        </script>
    <?php } ?>
<?php } ?>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

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