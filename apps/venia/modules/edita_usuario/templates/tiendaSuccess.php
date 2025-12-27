<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/tienda?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-medal kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <?php echo $usuario->getUsuario() ?> <small>  Seleccion de Tiendas&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
               <a href="<?php echo url_for($modulo.'/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
       <div class="kt-portlet__body">
        <?php $numero=0 ?>
        <?php foreach ($bodegas as $registro) { ?>
        <?php $numero++ ?>
        <div class="row "  >
            <div class="col-lg-2"></div>
            <div class="col-lg-4 font-blue-sharp bold Bold uppercase" <?php if ($numero%2==0)  { ?> style="background-color: #E6EEF2"   <?php } ?>><?php echo $registro->getNombre(); ?></div>
            <div class="col-lg-2"  <?php if ($numero%2==0)  { ?> style="background-color: #E6EEF2"   <?php } ?>><?php echo $form['numero_'.$registro->getId()]; ?></div>
   
        </div>
        <?php } ?>
         <div class="row "  >
            <div class="col-lg-8"></div>
          <div class="col-lg-2">
                <button class="btn btn-success  btn-block" type="submit">
                    <i class="fa fa-save "></i>
                    Actualizar
                </button>
            </div>
         </div>
    </div>
</div>
<?php echo '</form>'; ?>