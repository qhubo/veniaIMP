<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-bell-4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Detalle de Pagos <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                   Datos Ingresados </small>
            </h3>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>

    <div class="kt-portlet__body">
  <div class="row">
            <div class="col-lg-4"><strong>Fecha</strong></div>
            <div class="col-lg-8"><?php echo $vista->getFecha('d/m/Y'); ?></div>
        </div>
          <div class="row">
          <div class="col-lg-4"><strong>Tipo Pago</strong></div>
          <div class="col-lg-8"><?php echo $vista->getTipoPago(); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Gasto</strong></div>
            <div class="col-lg-8"><?php echo $vista->getGasto()->getCodigo(); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Banco</strong></div>
            <div class="col-lg-6" ><?php echo $vista->getBanco(); ?> </div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Total</strong></div>
            <div class="col-lg-6" style="text-align: right"><?php echo Parametro::formato($vista->getValorTotal()); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4"><strong>Usuario</strong></div>
        <div class="col-lg-6" ><?php echo $vista->getUsuario(); ?> </div>    </div>
                <div class="row">
            <div class="col-lg-4"><strong>Creacion</strong></div>
            <div class="col-lg-6" ><?php echo $vista->getCreatedAt(); ?> </div>     </div>

    




        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row" >
            <div class="col-lg-5" style="background-size: contain; background-image: url(./assets/media//bg/300.jpg); padding-top: 3px;padding-bottom: 3px"></div>
            <div class="col-lg-3" style="padding-top: 3px;padding-bottom: 3px">                <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary btn-hover-brand">Cancelar</button>
            </div>
        </div>
    </div>

</div>
