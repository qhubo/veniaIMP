<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-bell-4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Detalle de Valores <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Verifica la información  </small>
            </h3>

        </div>
        <div class="kt-portlet__head-toolbar">
      <a href="<?php echo url_for($modulo.'/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>

    <div class="kt-portlet__body">
<form action="<?php echo url_for($modulo . '/editar?id=' . $registro->getId()) ?>" method="get">
        <div class="row">
            <div class="col-lg-1"> </div>
            <div class="col-lg-2"><strong>Tipo</strong></div>
            <div class="col-lg-8"><?Php echo $registro->getTipoDetalle() ?></div>
        </div>
        <div class="row">
                        <div class="col-lg-1"> </div>
            <div class="col-lg-2"><strong>Grupo</strong></div>
            <div class="col-lg-6" ><?Php echo $registro->getGrupo() ?></div>
        </div>
        <div class="row">
                        <div class="col-lg-1"> </div>
            <div class="col-lg-2"><strong>Cuenta</strong></div>
            <div class="col-lg-6" style="text-align: right">
                <select class="form-control" name="cuenta" id="cuenta">
                    <?php foreach ($listaCuentas as $dat) { ?>
                        <option 
                        <?php if ($dat->getCuentaContable() == $registro->getCuentaContable()) { ?>
                                selected="selected"
                            <?php } ?>
                            value="<?php echo $dat->getCuentaContable(); ?>"><?php echo $dat->getCuentaContable(); ?> - <?php echo $dat->getNombre(); ?></option>
                        <?php } ?>
                </select>    


            </div>
        </div>
      
        <div class="row">
                        <div class="col-lg-8"> </div>

                        <div class="col-lg-2">    
                <button class="btn-block btn-success btn-xs  btn " type="submit">
                                <i class="fa fa-save "></i> Actualizar
                            </button>
                        </div>
        </div>
</form>




        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>

    </div>

</div>
