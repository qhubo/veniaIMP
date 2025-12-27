
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-zig-zag-line-sign kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                ESTADO DE CUENTA CLIENTE<small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a  target="_blank"  href="<?php echo url_for($modulo . '/reportePdf') ?>?clientev=<?php echo $clientev ?>&fecharef=<?php echo urlencode($fechaInicial) ?>" class="btn btn-warning" > 
                    <li class="fa fa-print"></li> Reporte  </a>

            
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="<?php echo url_for($modulo . '/index') ?>" method="get">
            <div class="row"> 
                <div class="col-lg-2" style="font-weight: bold; font-size: 14px; text-align: right;">Cliente </div>
                <div class="col-lg-6">
                    <select  onchange="this.form.submit()" class="form-control select2"  name="clientev" id="clientev">
                        <option value="0">[    Seleccione  ]</option>
                        <?php foreach ($clientes as $lista) { ?>
                            <option <?php if ($clientev == $lista->getId()) { ?> selected="selected"  <?php } ?>  value="<?php echo $lista->getId(); ?>"><?php echo $lista->getNombre(); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2" style="font-weight: bold; font-size: 14px; text-align: right;">Fecha Inicial </div>
                <div class="col-lg-2">
                    <input  onchange="this.form.submit()" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="fecharef" value="<?php echo $fechaInicial; ?>" id="fecharef">
                </div>
            
            </div>
        </form>        
        <div class="row">
            <div class="col-lg-12" style="padding-left: 20px; padding-right: 20px; padding-top: 20px;">
                <table class="table-bordered table-checkable table dataTable no-footer " xid="html_table" width="100%">
                    <tr>
                        <th>Documento</th>
                        <th>Fecha</th>
                        <th>Cargo</th>
                        <th>Abono</th>
                        <th>Saldo</th>
                        <th>Descripción
                  
                        </th>
                    </tr>
                    <?php foreach ($registros as $deta) { ?>
                        <tr>
                            <td><?php echo $deta['codigo']; ?></td>
                            <td><?php echo $deta['fecha']; ?></td>
                            <td style="text-align: right"><?php echo Parametro::formato($deta['cargo']); ?></td>
                            <td style="text-align: right"><?php  echo Parametro::formato($deta['abono']); ?></td>
                            <td style="text-align: right"><?php  echo Parametro::formato($deta['saldo']); ?></td>
                            <td><?php echo $deta['descripcion']; ?></td>
                        </tr>
                    <?php } ?>

                </table> 
            </div>
        </div>

    </div>
</div>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>


<script>
                        jQuery(document).ready(function ($) {
                            $(document).ready(function () {
                                $('.mi-selector').select2();
                            });
                        });
</script>