<?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="row" style="padding-bottom: 8px;">


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
  <div class="col-lg-1 control-label right ">Banco  </div>
    <div class="col-lg-3 <?php if ($form['banco']->hasError()) echo "has-error" ?>">
        <?php echo $form['banco'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['banco']->renderError() ?>  
        </span>
    </div>



    <div class="col-lg-2">
        <button class="btn btn-sm btn-outline-success" type="submit">
            <i class="fa fa-search "></i>
            Buscar
        </button>
    </div>

    <div class="col-lg-2">
<!--        <a class="btn btn-sm btn-outline-warning "   href="#<?php echo url_for('reporte/corteCaja') ?>"  target="_blank">
            <li class="fa fa-print"></li> Reporte
        </a>-->
    </div>
</div>

<?php echo '</form>' ?>


        <div class="row">
            <div class="col-lg-12">
<!--                <div class="row">
                    <div class="col-lg-10"></div>
                    <div class="col-lg-2">				
                        <div class="kt-input-icon kt-input-icon--left">
                            <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                            <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                <span><i class="la la-search"></i></span>
                            </span>
                        </div>
                    </div>
                </div>-->
                <table class="kt-datatable table-bordered " xid="html_table" width="100%">
                    <thead>
                        <tr class="info">
                            <th><font size="-2">Fecha </th>
                            <th><font size="-2">Usuario</th>
                            <th><font size="-2">Banco</th>
                            <th><font size="-2">Movimiento</th>
                            <th><font size="-2">Valor </th>
                            <th><font size="-2">Observaciones </th>
                              <th  align="center"><span class="kt-font-success"> Eliminar</span></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($operaciones as $regi) { ?>

                            <tr>
                                <td><font size="-2"><?php echo $regi->getFechaDocumento('d/m/Y'); ?></font></td>
                                <td><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>                     
                                <td>  <a href="<?php echo url_for($modulo . "/partida?id=" . $regi->getPartidaNo()) ?>" data-toggle="modal" data-target="#ajaxmodal<?php echo $regi->getId(); ?>">
                
                                    <font size="-2"><?php echo $regi->getBancoRelatedByBancoId()->getNombre(); ?>
                                    
                                    </font>
                                    </a> </td>
                                <td><font size="-2"><?php //echo $regi->getMedioPago()->getNombre(); ?>
                                    </font></td>
     <!--                        <td><?php echo $regi->getDocumento(); ?></td> -->
                                <td style="text-align: right" >
                                 <font size="-2">   <a href="<?php echo url_for('debito_banco/muestra?id=' . $regi->getId()) ?>" class="btn-sm btn btn-block btn-secondary btn-dark" >
                                        <?php echo Parametro::formato(abs( $regi->getValor())); ?>
                                    </a></font>
                                </td>                    
                                <td><font size="-2"><?php echo $regi->getObservaciones(); ?></font></td> 
                                        <td><a href="<?php echo url_for("proceso/rechaza?tipo=debito&token=" . $regi->getId()) ?>" class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#ajaxmodalRECHAZA<?php echo $regi->getId(); ?>"> <li class="fa flaticon2-cancel"></li>    </a></td>
      
                            </tr>      
                        <?php } ?>
                    </tbody>
                </table>
            </div>      

        </div>      



<?php foreach ($operaciones as $data) { ?>

    <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Débito  <?php echo $data->getId(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<div class="modal fade"  id="ajaxmodalRECHAZA<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog"  aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Rechazo Debito  <?php echo $data->getDocumento(); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
    </div>
<?php } ?>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  