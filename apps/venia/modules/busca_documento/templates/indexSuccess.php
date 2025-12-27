<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for('busca_documento/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Busqueda de factura proveedor
                <small>&nbsp;&nbsp;&nbsp; Colocar parte o numero completo  del  numero de documento a consultar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <label class="col-lg-2 control-label right "> No Documento </label>
            <div class="col-lg-3 <?php if ($form['numero']->hasError()) echo "has-error" ?>">
                <?php echo $form['numero'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['numero']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-2">
                <button class="btn green btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
            </div>
        </div>

        <div class="row" style="padding-top:10px;">
            <table class="table  table-bordered   dataTable "  width="100%">
                <tr style="background-color:#ebedf2">
                    <th>Fecha</th>
                    <th>Documento</th>
                    <th>Proveedor</th>
                    <th>Tipo</td>

                    <th>Pago</th>
                    <th>Total</th>
                </tr>
                <?php $conta=0; ?>
                <?php if ($registros) { ?>
                    <?php foreach ($registros as $data) { ?>
                <?php $conta++; ?>

                        <?php $urlQrcode = "https://felpub.c.sat.gob.gt/verificador-web/publico/vistas/verificacionDte.jsf?"; ?>
                        <?php $urlQrcode .= "tipo=autorizacion"; ?>
                        <?php $urlQrcode .= "&receptor=7933053"; // . $receptor ?> 
                        <tr>
                            <td style="text-align: center; align-content: center;"><?php echo $data['FECHA']; ?></td>
                            <td>
                                <?php if ($data['NO_SAT'] <> "") { ?>

                                    <?php $urlQrcode .= "&numero=" . $data['NO_SAT']; ?> 
                                    <?php $urlQrcode .= "&emisor=" . $data['emisor'] ?>
                                    <?php $urlQrcode .= "&monto=" . $data['monto']; ?>  

                                    <a target="_blank" href="<?php echo $urlQrcode; ?>" class="btn  btn-sm  btn-block" class="btn  btn-sm  btn-block" style="color:#146CB5 !important; border-color:#146CB5 !important ;" > 

                                        <?php echo html_entity_decode($data['DOCUMENTO']); ?>
                                    </a>
                                <?php } else { ?>
                                    <?php echo html_entity_decode($data['DOCUMENTO']); ?>

                                <?php } ?>
                            </td>
                            <td><?php echo $data['PROVEEDOR']; ?></td>
                            <td style="text-align:center; align-content: center;">
                                <a href="<?php echo url_for("reporte_partida/partida?id=" . $data['PARTIDA_NO']) ?>" data-toggle="modal" data-target="#ajaxmodal<?php echo $data['PARTIDA_NO']; ?>" class="btn  btn-sm  btn-block" class="btn  btn-sm  btn-block" style="color:#146CB5 !important; border-color:#146CB5 !important ;">

                                    <?php echo $data['TIPO']; ?>
                                </a>
                                <br>
                                <?php echo $data['ESTATUS']; ?>
                            </td>

                            <td>
                                <table width="100%">
                                    <?php if ($data['PAGOS']) { ?>
                                        <?php foreach ($data['PAGOS'] as $dt) { ?>
                                            <tr  style="padding:0.5px !important;">
                                                <th>Fecha</th>
                                                <td><?php echo $dt['fecha']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Usuario</th>
                                                <td><?php echo $dt['usuario']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Banco</th>
                                                <td><?php echo $dt['banco']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tipo</th>
                                                <td>
                                                    <a href="<?php echo url_for("reporte_partida/partida?id=" . $dt['partida_no']) ?>" data-toggle="modal" data-target="#ajaxmodal<?php echo $data['PARTIDA_NO']; ?>" class="btn  btn-sm  btn-block" style="color:#146CB5 !important; border-color:#146CB5 !important ;" >

                                                        <?php echo $dt['tipo_pago']; ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Documento</th>
                                                <td><?php echo $dt['documento']; ?></td>
                                            </tr> 
                                            <tr>
                                                <th>Total</th>
                                                <td><?php echo Parametro::formato($dt['valor_total']); ?></td>
                                            </tr> 
                                        <?php } ?>
                                    <?php } ?>



                                </table>


                            </td>

                            <td style="text-align: right; align-content: right;">
                                    <?php if ($data['TIPO'] == "GASTO") { ?>
                        <a href="<?php echo url_for("orden_gasto/vista?id=" . $data['ID']) ?>" class="btn btn-block btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodalT<?php echo $conta; ?>">
                          <?php echo Parametro::formato($data['TOTAL'], 2); ?>
                        </a>
                    <?php } elseif ($data['TIPO'] == "GASTO CAJA") { ?>
                        <a href="<?php echo url_for("orden_gasto/vista?linea=" .  $data['ID']) ?>" class="btn btn-block btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodalT<?php echo $conta; ?>">
                        <?php echo Parametro::formato($data['TOTAL'], 2); ?>
                        </a>
                     <?php } elseif ($data['TIPO'] == "ORDEN COMPRA") { ?>
                        <a href="<?php echo url_for("orden_compra/vista?idv=" .  $data['ID']) ?>" class="btn btn-block btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodalT<?php echo $conta; ?>">
                        <?php echo Parametro::formato($data['TOTAL'], 2); ?>
                        </a>
                  
                    <?php } else { ?>

                    <?php } ?>
    
                                
                               
                            
                            
                            </td>

                        </tr>

                    <?php } ?>
                <?php } ?>
            </table>
        </div>

        <?php if ($registros) { ?>
          <?php $conta=0; ?>
            <?php foreach ($registros as $data) { ?>
        
        
            <?php $conta++; ?>
    <?php $lista = $data; ?>
    <div class="modal fade"  id="ajaxmodalT<?php echo $conta; ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Gasto  <?php echo $data['CODIGO']; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
        
                <div class="modal fade" xstyle="width:900px"  id="ajaxmodal<?php echo $data['PARTIDA_NO']; ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
                     role="dialog"  aria-hidden="true" >
                    <div class="modal-dialog" xstyle="width:900px" role="document">
                        <div class="modal-content" xstyle="width:750px">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel6">Detalle </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"></div>
                        </div>
                    </div>
                </div>    

                <?php if ($data['PAGOS']) { ?>
                    <?php foreach ($data['PAGOS'] as $dt) { ?>
                        <div class="modal fade" xstyle="width:900px"  id="ajaxmodal<?php echo $dt['partida_no']; ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
                             role="dialog"  aria-hidden="true" >
                            <div class="modal-dialog" xstyle="width:900px" role="document">
                                <div class="modal-content" xstyle="width:750px">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel6">Detalle </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body"></div>
                                </div>
                            </div>
                        </div>    

                    <?php } ?>

                <?php } ?>

            <?php } ?>
        <?php } ?>


    </div>

</div>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  