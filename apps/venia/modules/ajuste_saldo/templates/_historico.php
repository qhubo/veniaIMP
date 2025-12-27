<?php echo $form->renderFormTag(url_for($modulo.'/index?id=1'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="row">


    <div class="col-lg-1 control-label right "> Inicio </div>
    <div class="col-lg-3 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
        <?php echo $form['fechaInicio'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['fechaInicio']->renderError() ?>  
        </span>
    </div>



    <div class="col-lg-1 control-label right ">Fin  </div>
    <div class="col-lg-3 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
        <?php echo $form['fechaFin'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['fechaFin']->renderError() ?>  
        </span>
    </div>



    <div class="col-lg-2">
        <button class="btn btn-sm btn-outline-success" type="submit">
            <i class="fa fa-search "></i>
            Buscar
        </button>
    </div>

    <div class="col-lg-2">
        <a class="btn btn-sm btn-outline-warning "   href="#<?php echo url_for('reporte/corteCaja') ?>"  target="_blank">
            <li class="fa fa-print"></li> Reporte
        </a>
    </div>
</div>

<?php echo '</form>' ?>
<div class="row">

    <div class="col-lg-12">   

           <div class="row">
                    <div class="col-lg-11">
                           <div class="row">
                    <div class="col-lg-10"></div>
                        <div class="col-lg-2">				
                                <div class="kt-input-icon kt-input-icon--left">
                                    <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                        </div>
                    </div>
	 <table class="kt-datatabl table-bordered " id="html_table" width="100%">
            <thead>
                <tr class="info">
          <th>Fecha </th>
                    <th>Usuario</th>

                    <th>Banco</th>
<!--                    <th> Referencia </th>-->
                    <th>Valor </th>
                     <th>Observaciones </th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($operaciones as $regi) { ?>
       
                    <tr>
                        <td><?php echo $regi->getFechaDocumento('d/m/Y'); ?></td>
                        <td><?php echo $regi->getUsuario(); ?></td>
                        <td><?php echo $regi->getBancoRelatedByBancoId()->getNombre(); ?></td>
<!--                        <td><?php echo $regi->getDocumento(); ?></td> -->
                        <td style="text-align: right"> <?php echo Parametro::formato($regi->getValor()); ?></td>                    
                      <td><?php echo $regi->getObservaciones(); ?></td> 
                    </tr>      
                <?php } ?>
            </tbody>
        </table>
    </div>      

</div>      
