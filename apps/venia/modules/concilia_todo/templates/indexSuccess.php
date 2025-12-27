<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-zig-zag-line-sign kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                CONCILIACIONES DE BANCOS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Selecciona el banco que desea imprimir
                </small>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar"> 
            <form action="<?php echo url_for('concilia_todo/index') ?>" method="get">
                <input onchange="this.form.submit()" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="fecha" value="<?php echo $fecha; ?>" id="fecha">
            </form>     
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php include_partial('concilia_todo/tasa', array('dia' => $dia)) ?>  

     
        
        <div class="row">
            <?php $i = 0; ?>
            <?php foreach ($bancos as $banco) { ?>
            
                <?php $i = $banco->getId(); ?>
                <?php $seleccionV = sfContext::getInstance()->getUser()->getAttribute('selecBa' . $banco->getId(), '', 'seguridad'); ?>
                <?php $valor = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), '', 'seguridad'); ?>
                <?php $ValorBanco = sfContext::getInstance()->getUser()->getAttribute('valor' . $banco->getId(), null, 'conciliado'); ?>
                <?php $valor = $banco->getHsaldoBanco($dia); ?>              
                <?php $ValorBanco = $banco->getHsaldoConciliado($dia); ?>   
                <?php $retorna = $banco->getHDiferencia($dia); ?>
                <?php if ($seleccionV == 1) { ?>
                    <?php $estiloDos = ''; ?>
                    <?php $estiloUno = 'style="display:none;"'; ?>
                <?php } else { ?>
                    <?php $estiloUno = ''; ?>
                    <?php $estiloDos = 'style="display:none;"'; ?>
                <?php } ?>
                <input type='hidden' readonly="true" class="form-control" value="<?php echo Parametro::formato($banco->getSaldoTransito(), false); ?> " style="background-color:#F9FBFE ;"  name="totalconfirma" id="totalconfirma"> 
                <div class="col-lg-6" >
                    <div  style="border:1px solid #ccc!important; padding: 0.12em 16px; margin-top: 10px; ">
                        <div class="row" style=" margin-left: 10px; margin-right: 10px; padding-top: 10px; padding-bottom: 10px; padding-right: 20px; padding-left: 20px " >
                            <div class="col-lg-12">
                                <?php include_partial('concilia_todo/encabezado', array('dia' => $dia, 'banco' => $banco, 'valor' => $valor)) ?>  
                                <?php include_partial('concilia_todo/transito', array('banco' => $banco, 'dia' => $dia)) ?>  
                                <div class="row">
                                    <div class="col-lg-10">
                                        <table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">
                                            <thead>
                                                <tr class="active">
                                                    <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px">Saldo Conciliado</th>
                                                    <td style="text-align: right; padding-right: 10px">
                                                            <div>
                    <div style="float:left">
                <strong>Q </strong>
                    </div>
                    <div style="float:right">
                                                        
                                                        <input  readOnly="true" class="form-control"    name="totalconcilia<?php echo $i; ?>" id="totalconcilia<?php echo $i; ?>" <?php if ($ValorBanco) { ?> value="<?php echo $ValorBanco ?>"  <?php } else { ?> value="<?php echo $banco->getSaldoTransitoBanco(); ?>" <?php } ?> >
                    </div>
                                                            </div>
                                                         </td>
                                                        </tr>
                                                <tr class="active">
                                                    <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px">Diferencia</th>
                                                    <td style="text-align: right; padding-right: 10px"> 
                                                            <div>
                    <div style="float:left">
                <strong>Q </strong>
                    </div>
                    <div style="float:right">
                                                        <input class="form-control"  type="text" readOnly="true"  style="background-color:#F9FBFE ;"  name="totaldiferencia<?php echo $i; ?>" id="totaldiferencia<?php echo $i; ?>"   value="<?php echo $retorna; ?>"  > 
                    </div>
                                                            </div>
                                                        </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-lg-1">
                                        <br>
                                        <div  id="bNtactiva<?php echo $i ?>" <?php echo $estiloDos ?>>
                                            <a id="Nactivar<?php echo $i ?>"  vivi="<?php echo $banco->getId(); ?>"  dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/Check.png"></a> 
                                        </div> 
                                                        
                                        <br>
                                        <a target="_blank" href="<?php echo url_for('reporte/conciliaBanco').'?bancoId=' . $banco->getId()."&fecha=".$fecha  ?>" class="btn  btn-sm btn-warning" > <i class="flaticon2-printer"></i>Reporte </a>
                                        <div   id="btlista<?php echo $i ?>"  <?php echo $estiloUno ?> >
                                            <a id="activar<?php echo $i ?>" vivi="<?php echo $banco->getId(); ?>" dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/UnCheck.png"> </a>     
                                        </div> 
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>





<?php include_partial('concilia_todo/script', array('bancos' => $bancos,'fecha'=>$dia)) ?>  


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>