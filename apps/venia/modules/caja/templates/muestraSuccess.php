<?php $modulo = $sf_params->get('module'); ?>
<?php $estiloUno = ''; ?>
<?php $estiloDos = 'style="display:none;"'; ?>
<?php $vivienda = $Operacion->getVivienda(); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-coins kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                DETALLE DE PAGO <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $Operacion->getCodigo(); ?> </strong></span>
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
                       <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-1">Sector </div>
            <div class="col-lg-5 ">
                <input class="form-control"   placeholder="Sector" 
                       <?php if ($vivienda) { ?>  value="<?php echo $vivienda->getSector(); ?>"   <?php } ?> readonly="true"> 
            </div>
            <div class="col-lg-1">Número </div>
            <div class="col-lg-3 ">
                <input class="form-control"  placeholder="Número" 
                       <?php if ($vivienda) { ?>  value="<?php echo $vivienda->getNumero(); ?>"
                       <?php } ?>    readonly="true">          
            </div>
        </div>
        <?php if ($vivienda) { ?>
            <div class="row">
                <div class="col-lg-1"> </div>
                <div class="col-lg-1"> Dirección</div>
                <div class="col-lg-9">
                    <input class="form-control" readonly="true"  type="text"  value="<?php echo $vivienda->getDireccion(); ?>" >
                </div>        
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-1"> Factura</div>
            <div class="col-lg-3">
                <input class="form-control" value="<?php echo $Operacion->getNombre(); ?>" readonly="true">
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-1">Nit</div>
            <div class="col-lg-3">
                <input class="form-control" value="<?php echo $Operacion->getNit(); ?>" readonly="true">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <table class="table table-striped- table-bordered table-hover "  width="100%">
                    <thead>
                        <tr class="active">
                            <th  align="center"> Código</th>
                            <th   align="center"> Detalle </th>
                            <th  align="center">Valor Pagado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach ($Detalle as $lista) { ?>
                        <tr>
                            <td><?php echo $lista->getCuentaVivienda()->getCodigo(); ?></td>
                            <td><?php echo $lista->getDetalle(); ?></td>
                            <td><?php echo number_format($lista->getValorTotal(), 2); ?></td>


                        </tr>

                    <?php } ?>
                </table>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6"><strong>Tipo</strong></div>
                    <div class="col-lg-6"><?php echo $Pago->getTipo(); ?> </div>

                </div>

                <div class="row">
                    <div class="col-lg-6"><strong>Valor</strong></div>

                    <div class="col-lg-6"><?php echo number_format($Pago->getValor(),2) ?> </div>

                </div>
                <div class="row">
                    <div class="col-lg-6"><strong>Documento</strong></div>

                    <div class="col-lg-6"><?php echo $Pago->getDocumento() ?> </div>

                </div>
                <div class="row">
                    <div class="col-lg-6"><strong>Fecha Documento</strong></div>

                    <div class="col-lg-6"><?php echo $Pago->getFechaDocumento('d/m/Y'); ?> </div>

                </div>
            </div>

        </div>

    </div>
</div>
