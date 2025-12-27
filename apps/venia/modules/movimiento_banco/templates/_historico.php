<?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="row" style="padding-bottom: 10px">


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
        <div class="row">
            <div class="col-lg-12">
                <!--                           <div class="row">
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
                            <th><font size="-2">Fecha </font></th>
                            <th><font size="-2">Usuario</font></th>
                            <th><font size="-2">Origen</font></th>
                            <th><font size="-2">Destino</font></th>
        <!--                    <th> Referencia </th>-->
                            <th><font size="-2">Valor </font></th>
                            <th><font size="-2">Observaciones </font></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($operaciones as $regi) { ?>

                            <tr>
                                <td><font size="-2"><?php echo $regi->getFechaDocumento('d/m/Y'); ?></font></td>
                                <td><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>
                                <td><font size="-2"><?php echo $regi->getBancoRelatedByBancoOrigen()->getNombre(); ?></font></td>
                                <td><font size="-2"><?php echo $regi->getBancoRelatedByBancoId()->getNombre(); ?></font></td>
        <!--                        <td><?php echo $regi->getDocumento(); ?></td> -->
                                <td style="text-align: right" ><font size="-2">
                                    <a href="<?php echo url_for('movimiento_banco/muestra?id=' . $regi->getId()) ?>" class="btn btn-sm tn-block btn-secondary btn-dark" >
                                        <?php echo Parametro::formato($regi->getValor()); ?>
                                    </a></font>
                                </td>                    
                                <td><font size="-2"><?php echo $regi->getObservaciones(); ?></font></td> 
                            </tr>      
                        <?php } ?>
                    </tbody>
                </table>
            </div>      
        </div>      
    </div>
</div>