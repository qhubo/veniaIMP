<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-list-1 kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success"> Reporte de Moviminetos Bancos
                <small>&nbsp;&nbsp;&nbsp; Visualiza por un rango de fechas  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row" style="padding-bottom: 4px;">
            <div class="col-lg-1"></div>
            <div class="col-lg-1 control-label right "> Inicio </div>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-1 control-label right ">Fin  </div>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
        </div>
         <div class="row" style="padding-bottom: 8px;">
             <div class="col-lg-1"></div>
            <div class="col-lg-1 control-label right ">Banco  </div>
            <div class="col-lg-3 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
                <?php echo $form['banco'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['banco']->renderError() ?>  
                </span>
            </div>
                  <div class="col-lg-1 control-label right ">Movimiento  </div>
            <div class="col-lg-2 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-sm btn-outline-success" type="submit">
                    <i class="fa fa-search "></i>
                    Buscar
                </button>
            </div>

                 <div class="col-lg-1">
                     <a target="_blank" href="<?php echo url_for( 'reporte_banco/reporte')  ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
          </div>
        </div>

        <?php echo '</form>' ?>

        <?php include_partial($modulo . '/historico', array( 'dolares'=>$dolares, 'form' => $form, 'modulo' => $modulo, 'operaciones' => $operaciones)) ?> 

    </div>
</div>



