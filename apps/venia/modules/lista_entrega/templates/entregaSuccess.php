<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-signs  kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
              Entrega
                <small>  &nbsp;&nbsp;&nbsp;&nbsp; Procede a realizar la entrega</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
     <div class="kt-portlet__body">

        <div class="row">
                  <div class="col-lg-2"><strong> <font size="+1">Código</font></strong></div>
                    <div class="col-lg-2"><font size="+1"><?php echo $operacion->getCodigo(); ?></font></div>
                    <div class="col-lg-1"><strong><font size="+1">Nit</font></strong></div>
                    <div class="col-lg-2"><font size="+1"><?php echo $operacion->getNit(); ?></font></div>
                    <div class="col-lg-2"><strong> <font size="+1">Cliente</font></strong></div>
                    <div class="col-lg-3"><font size="+1"><?php echo $operacion->getNombre(); ?></font></div>
           </div>
<div class="row">
     <div class="col-lg-12" style="padding-top: 10px;">
                  <?php include_partial('lista_entrega/detalle', array('form'=>$form, 'operacion' => $operacion, 'detalle' => $detalle, 'pagos' => $pagos)) ?>  
     </div>
        </div>
        </div>

    </div>




