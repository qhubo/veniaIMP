<style>
    .titulo {
        font-size: 15px !important;
        /*        font-family: "Lucida Console", "Courier New", monospace !important;*/
    }
</style>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-interface-2 text-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                CAPTURA DE  DATOS DE VISITA <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href=" <?php echo url_for('reporte_visita/index') ?>" class="btn  btn-sm btn-success btn-secondary" > <i class="flaticon2-list-1"></i> Historial </a>
            <?php //echo $form['fecha_visita'] ?> 
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=' . $id), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>

        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Establecimiento <font color="red" size="+2">*</font> </div>
            <div class="col-lg-8 <?php if ($form['establecimiento']->hasError()) echo "has-error" ?>">
                <?php echo $form['establecimiento'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['establecimiento']->renderError() ?>  
                </span>
            </div>
        </div>
        <?php if (count($detalle) >0) { ?>
        <?php include_partial($modulo . '/datosCompri', array('id' => $id, 'modulo' => $modulo, 'form' => $form)) ?>
        <?php } else { ?>
  <?php include_partial($modulo . '/datos', array('id' => $id, 'modulo' => $modulo, 'form' => $form)) ?>
            
  <?php } ?>
        <div class="row" style='padding-top:2px;'>
            <div class="col-lg-12" style="text-align:center"><h4>Repuesto Sugerido</h4></div>
        </div>

         <?php if (count($detalle) >0) { ?>
            <div class="row">
                <div class="col-lg-12" >
                <table class="table table-bordered" >
                    <tr style="background-color:#ebedf2">
                        <th align="center"  width="20%" ><font size="-1">Hollander</font></th>
                        <th align="center" ><font size="-1">Repuesto</font></th>
                        <th width="10px"></th>
                    </tr>
                    <?php foreach ($detalle as $dat) { ?>
                        <tr>
                            <td><font size="-1"><?php echo $dat->getHollander(); ?></font></td>
                            <td><font size="-1"> <?php echo $dat->getRepuesto(); ?></font></td>
                            <td>
                                <a class="btn btn-sm btn-danger" href="<?php echo url_for("captura_datos/elimina?id=" . $dat->getId()) ?>"> 
                                    <li class="fa flaticon2-cancel"></li>  
                                </a>

                            </td>
                        </tr>
                    <?php } ?>

                </table>
                </div>
            </div>
        <?php } ?>

        <div class="row " style='padding-top:1px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Hollander </div>
            <div class="col-lg-8 <?php if ($form['hollander']->hasError()) echo "has-error" ?>">
                <?php echo $form['hollander'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['hollander']->renderError() ?>  
                </span>
            </div>
        </div>

        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Repuesto </div>
            <div class="col-lg-8 <?php if ($form['repuesto']->hasError()) echo "has-error" ?>">
                <?php echo $form['repuesto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['repuesto']->renderError() ?>  
                </span>
            </div>
        </div>


        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-5">       </div>
            <div class="col-lg-4" style="padding-bottom:4px;">
                <?php if ($id) { ?>
                    <button class="btn btn-block btn-sm  btn-secondary btn-dark" " type="submit">
                        <i class="flaticon2-plus "></i>
                        AGREGAR REPUESTO 
                    </button>
                <?php } else { ?>
                    <button class="btn btn-block btn-primary " type="submit">
                        <i class="fa fa-save "></i>
                        Almacenar
                    </button>
                <?php } ?>
            </div>
            <div class="col-lg-2"> </div>
  </div>
 <?php if (count($detalle) >0) { ?>
         <div class="row " style='padding-top:4px;'>
            <div class="col-lg-5">       </div>
            
              <div class="col-lg-4" style="padding-bottom:4px;">
        
            <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-success  btn-block" > <i class="fa fa-lock"></i> Confirmar</a>
              </div>
         </div>
<?php } ?>
    </div>
</div>



<?php include_partial($modulo . '/script', array('id' => $id, 'modulo' => $modulo)) ?>
