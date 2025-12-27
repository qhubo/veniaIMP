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
                     <a target="_blank" href="<?php echo url_for( $modulo.'/reporteExcel')  ?>" class="btn  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
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
    
    <div class='row'>
        <div class='col-lg-12'><br></div>
        
    </div>
    <table class="table table-bordered  dataTable table-condensed flip-content" >

        <tr>

            <th align="center" > Fecha</th>
            <th align="center" > Usuario</th>
              <th align="center" > Tipo</th>
            <th align="center" > Banco</th>
            <th align="center" > Numero</th>
            <th align="center" > Nombre</th>

            <th align="center" > Valor Total</th>
            <th align="center" > Estatus</th>
             <th align="center" > Reporte</th>
            <th align="center" >Acción</th>
        </tr>
        <?php foreach ($cheques as $registro) { ?>
            <tr>
                <td><?php echo $registro->getFechaCheque('d/m/Y'); ?></td>
                <td><?php echo $registro->getUsuario(); ?></td>
                 <td><?php echo $registro->getTipoDetalle(); ?></td>
                <td><?php echo $registro->getBanco(); ?></td>
                <td><?php echo $registro->getNumero(); ?></td>
                <td><?php echo $registro->getBeneficiario(); ?></td>
                <td style="text-align: right" ><?php echo Parametro::formato($registro->getValor()); ?></td>
                 <td><?php echo $registro->getEstatus(); ?></td>
                 <td>   <a target="_blank" href="<?php echo url_for('reporte/cheque?id='.$registro->getId()) ?>" class="btn  btn-sm  btn-warning" > <i class="flaticon2-print"></i> Reporte </a>
</td>
                <td>
                    <?php //if ($registro->getFechaCheque('Ym') == date('Ym')) { ?>
                    <?php if ($registro->getEstatus() <>"Anulado") { ?>
                    <a href="<?php echo url_for("proceso/rechaza?tipo=creacheque&token=" . $registro->getId()) ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ajaxmodalRECHAZA<?php echo $registro->getId(); ?>"> <li class="fa flaticon2-cancel"></li>    </a>
                    <?php } ?>
                    <?php //} ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php echo '</form>'; ?>     

 <?php foreach ($cheques as $data) { ?>
<div class="modal fade"  id="ajaxmodalRECHAZA<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog"  aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Creación de Cheque  <?php echo $data->getNumero(); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
    </div>
 <?php } ?>

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>