<?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="row">
    <div class="col-lg-12"><br><br><br><br></div> 
</div>
<div class="table-scrollable">
    <div class="row">
        <label class="col-lg-1 control-label right "> Inicio </label>
        <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
            <?php echo $form['fechaInicio'] ?>           
            <span class="help-block form-error"> 
                <?php echo $form['fechaInicio']->renderError() ?>  
            </span>
        </div>
        <label class="col-lg-1 control-label right "> Fin </label>
        <div class="col-lg-3 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
            <?php echo $form['fechaFin'] ?>           
            <span class="help-block form-error"> 
                <?php echo $form['fechaFin']->renderError() ?>  
            </span>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-2">
            <button class="btn green btn-outline" type="submit">
                <i class="fa fa-search "></i>
                Buscar
            </button>
        </div>


        <div class="col-lg-2">
            <a target="_blank" href="<?php echo url_for($modulo . '/reporteExcel') ?>" class="btn  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
        </div>

    </div>
    <div class="row">
        <label class="col-lg-1 control-label right "> Banco </label>

        <div class="col-lg-3 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
            <?php echo $form['banco'] ?>           
            <span class="help-block form-error"> 
                <?php echo $form['banco']->renderError() ?>  
            </span>
        </div>
        <div class="col-lg-3 <?php if ($form['estatus']->hasError()) echo "has-error" ?>">
            <?php echo $form['estatus'] ?>           
            <span class="help-block form-error"> 
                <?php echo $form['estatus']->renderError() ?>  
            </span>
        </div>

    </div>

         <div class="row">
            <div class="col-lg-7"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-2">
             
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
         
            </div>
        </div>
                <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">

        <tr>

            <th align="center" > Fecha</th>
            <th align="center" >Codigo</th>
            <th align="center" > Tienda</th>
            <th align="center" >Banco</th>
            <th align="center" > Fecha Deposito</th>
            <th align="center" > Boleta</th>
            <th align="center" > Total</th>
           <th align="center" >Documento Banco</th>
                        <th align="center" >Estatus</th>
<!--            <th align="center" > Cliente</th>
              <th align="center" > Vendedor</th>-->
<!--            <th align="center" > Telefono</th>
            <th align="center" >Pieza</th>
            <th align="center" >Stock</th>-->
           
<!--            <th align="center" >Usuario Confirmo</th>-->
            <th>Anular</th>


        </tr>
        <?php foreach ($boletas as $registro) { ?>
            <tr>
                <td>
                    
                    <div style="text-align:center">
                    <?php echo $registro->getCreatedAt('d/m/Y'); ?><br> <?php echo $registro->getCreatedAt('H:i'); ?>
                    </div>
                    </td>
                <td>
                    <?php if ($registro->getEstatus()=="Autorizado") { ?>
                     <a target="_blank" href="<?php echo url_for('captura_datos_boleta/reporte?id=' . $registro->getId()) ?>" class="btn btn-outline  btn-sm " > <i class="flaticon2-printer"></i><?php echo $registro->getBoleta(); ?> </a>
                    <?php }  else { ?> 
                  <?php echo $registro->getCodigo(); ?>
                    <?php } ?>
                </td>
                <td><?php echo $registro->getTienda()->getNombre(); ?></td>
                <td><?php echo $registro->getBanco()->getNombre(); ?></td>
                <td><?php echo $registro->getFechaDeposito('d/m/Y'); ?></td>
                <td><?php echo $registro->getBoleta(); ?></td>
                <td style="text-align: right" >
                                        <div style="text-align:right">
                    <?php echo Parametro::formato($registro->getTotal()); ?>
                                        </div>
                                        </td>
              
                 <td><?php echo $registro->getDocumentoConfirmacion(); ?></td>
                                <td><?php echo $registro->getEstatus(); ?></td>
<!--                <td><?php echo $registro->getCliente(); ?></td>
                  <td><?php echo $registro->getVendedor(); ?></td>-->
<!--                <td><?php echo $registro->getTelefono(); ?></td>
         <td><?php echo $registro->getPieza(); ?></td>
                <td><?php echo $registro->getStock(); ?></td>-->
   
<!--        <td><?php echo $registro->getUsuarioConfirmo(); ?></td>-->
        <td>     <a href="<?php echo url_for("proceso/rechaza?tipo=boleta&token=" . $registro->getCodigo()) ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ajaxmodalRECHAZA<?php echo $registro->getId(); ?>"> <li class="fa flaticon2-cancel"></li>    </a>
                </td>

         
                <td>
                
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php echo '</form>'; ?>     


 <?php foreach ($boletas as $registro) {  ?>
<div class="modal fade"  id="ajaxmodalRECHAZA<?php echo $registro->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog"  aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Anulación de Boleta<?php echo $registro->getCodigo(); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
    </div>
 <?php } ?>

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>