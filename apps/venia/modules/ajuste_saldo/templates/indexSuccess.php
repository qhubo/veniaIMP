<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> Ajuste Saldo
                <small>&nbsp;&nbsp;&nbsp; Ingresa una nuevo ajuste  y/o visualiza por un rango de fechas  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
       
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-4"><h3>Bancos</h3> 
                <div class="row">
                    <div class="col-lg-11">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td>Banco</td>
                            <td>Nombre</td>
                            <td>Saldo </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bancos as $registr) { ?>
                        <tr>
                            <td><?php echo $registr->getCodigo() ?></td>
                            <td><?php echo $registr->getNombre(); ?></td>
                            <td style="text-align: right"><?php echo Parametro::formato("0.0")  // echo $registr ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                    </div>
                </div>



            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4"><h3>Ajustes </h3></div>
                    <div class="col-lg-2">     <a href="<?php echo url_for($modulo . '/nueva') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nuevo </a></div>
                </div>
                <div class="row">
                    <div class="col-lg-12"><br></div>
                </div>
                
                <?php include_partial($modulo . '/historico', array('form' => $form, 'modulo' => $modulo, 'operaciones'=>$operaciones )) ?> 
            </div>
        </div>
    </div>
</div>