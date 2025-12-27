<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                CARGA ARCHIVO PAGOS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn-sm btn-info" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10">        </div>
        <div class="col-lg-2">       
            <a href="<?php echo url_for("carga/index?tipo=pago") ?>" class="btn btn-dark" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa flaticon-upload"></li> Importar archivo   </a>
        </div>
    </div>


    <div class="kt-portlet__body">
        <table class="table table-striped- table-bordered table-hover "  width="100%">
            <thead>
                <tr class="active">
                    <th  align="center"><span class="kt-font-success"> Código Servicio</span></th>
                    <th  align="center"><span class="kt-font-success"> Código Propiedad</span></th>           
                    <th   align="center"><span class="kt-font-success"> Detalle </span></th>
                    <th  align="center"><span class="kt-font-success"> Fecha Documento </span></th>
                    <th   align="center"><span class="kt-font-success"> Tipo</span></th>
                    <th   align="center"><span class="kt-font-success"> Documento</span></th>
                    <th   align="center"><span class="kt-font-success"> Valor</span></th>
                    <th   align="center"><span class="kt-font-info"> Check</span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos as $registro) { ?>
                    <tr>

                        <td><?php echo $registro['CODIGO_SERVICIO']; ?></td>
                        <td><?php echo $registro['CODIGO_PROPIEDAD']; ?></td>
                        <td><?php //echo $registro[''];  ?></td>
                        <td><?php echo $registro['FECHA_DOCUMENTO']; ?></td>
                        <td><?php echo $registro['TIPO_PAGO']; ?></td>
                        <td><?php echo $registro['DOCUMENTO']; ?></td>

                        <td align="right"><?php echo number_format($registro['VALOR'],2); ?></td>

                        <td>
                            <?php if ($registro['VALIDO'])  { ?>
            <li class="fa fa-check"></li>
                            <?php } ?>
 
                            <font size="-2"><?php echo $registro['MENSAJE']; ?> </font>
                        </td>


                    </tr>

                <?php } ?>

            </tbody>
            <tr>
                <td colspan="7"></td>
                <td>     
                    <a href="<?php echo url_for("pago_archivo/procesa") ?>" class="btn btn-success" > <li class="fa fa-check"></li> Procesar   </a>
                </td>
            </tr>
        </table>


    </div>
</div>
<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>