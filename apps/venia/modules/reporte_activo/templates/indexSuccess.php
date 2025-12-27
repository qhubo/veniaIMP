<!--<script src='/assets/global/plugins/jquery.min.js'></script>-->
<?php $modulo = $sf_params->get('module'); ?>
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">Reporte de Activos
                <small>Filtra por Rango de  Fecha&nbsp;&nbsp;&nbsp;</small>
            </h3>  
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
         <?php $modulo = $sf_params->get('module'); ?>
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
              <div class="row">
                <label class="col-lg-1 control-label right "> Periodo </label>
                <div class="col-lg-2 <?php if ($form['mes_inicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['mes_inicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['mes_inicio']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-2 <?php if ($form['anio_inicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['anio_inicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['anio_inicio']->renderError() ?>  
                    </span>
                </div>


            </div>
       
            <div class="row" style="padding-top:10px">
                <label class="col-lg-1 control-label right ">Cuenta  </label>
                <div class="col-lg-4 <?php if ($form['cuenta_contable']->hasError()) echo "has-error" ?>">
                    <?php echo $form['cuenta_contable'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['cuenta_contable']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-2">
                    <button class="btn green btn-outline" type="submit">
                        <i class="fa fa-search "></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
  

            <div class="row">
                <div class="col-lg-6"> </div>                        
                <div class="col-lg-2">
                    <a target="_blank" href="<?php echo url_for($modulo.'/reporte?todos=1') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte Activos y Vencidos</a>
                </div>

                <div class="col-lg-2">
                    <a target="_blank" href="<?php echo url_for($modulo.'/reporte') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i>Reporte Activos</a>
                </div>
                
                 <div class="col-lg-2">
                
                          <a href="<?php echo url_for($modulo."/partida") ?>" class="btn-dark btn  btn-sm btn-block" data-toggle="modal" data-target="#ajaxmodal"> <i class="flaticon-list"></i> Partida   </a>
         </div>
            </div>
        <?php echo "</form>"; ?>
        
              <div class="row">
            <div class="col-lg-7"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-2" style="padding-top:7px; padding-bottom:7px;">
      
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
             
            </div>
        </div>
        <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
        
            
<!--        <table class="table table-bordered  dataTable table-condensed flip-content" >-->
            <thead class="flip-content">
                <tr class="active">
                    <th align="center" ><font size="-1"> Codigo</font></th>
                    <th align="center" width="20px"><font size="-1">Account</font></th>
                    <th align="center" ><font size="-1">Nombre Cuenta</font></th>
                    <th align="center" ><font size="-1">Description</font></th>
                    <th align="center" ><font size="-1">Adquisition Date</font></th>
                    <th align="center" ><font size="-1">Ending Date</font></th>
                    <th align="center" ><font size="-1">Life Years</font></th>
                    <th align="center" ><font size="-1"> Book Value</font></th>
                    <th align="center" ><font size="-1">% </font></th>

                    <th align="center" ><font size="-1">Life Years</font></th>
                    <th align="center" ><font size="-1">Anual Depreciation</font></th>
                    <th align="center" ><font size="-1">Months Depreciation</font></th>
                    <th align="center" ><font size="-1">Monthly Depreciation</font></th>
                   

       <th align="center" ><font size="-1">Meses Transcurridos <?php echo $fechaINICIAL; ?> </font></th>
       <th align="center" ><font size="-1">Años Transcurridos <?php echo $fechaINICIAL; ?></font></th>
    <th align="center" ><font size="-1">Depreciación Periodo Anterior <?php //echo $fechaINICIAL; ?></font></th> 
       <th align="center" ><font size="-1">Depreciación Acumulada <?php echo $fechaINICIAL; ?></font></th> 
        <th align="center" ><font size="-1">Valor Libro <?php echo $fechaINICIAL; ?></font></th> 
       <th>Activo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $data) { ?>
                <?php $valorLibros = ($data->getValorLibro()-$data->getDepreAcumulada($fechaINICIAL)); ?>
                <?php if ($valorLibros>0) { ?>
                    <tr>
                        <td><font size="-1"><?php  if($data->getCodigo()){  ?> 
                        <?php echo  $data->getCodigo(); ?> <?php } else {  ?> 
                            <?php echo  $data->getId(); ?> <?php } ?></font></td>
                        <td><font size="-1"><?php echo $data->getCuentaContable(); ?></font></td>
                        <td><font size="-1"><?php echo $data->getCuentaErpContable()->getNombre(); ?></font></td>
                        <td><font size="-1"><?php echo $data->getDetalle(); ?></font></td>
                        <td style="text-align:center"><font size="-1"><?php echo $data->getFechaAdquision('d/m/Y'); ?></font></td>
                        <td style="text-align:center"><font size="-1"><?php echo $data->getFechaVence(); ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo $data->getAnioUtil(); ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo Parametro::formato($data->getValorLibro(), true); ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo $data->getPorcentaje(); ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo $data->getAnioUtil();  ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo Parametro::formato($data->getDepreAnual(),true);  ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo $data->getNoMeses();  ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo Parametro::formato($data->getDepreMensual($fechaINICIAL),true);  ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo $data->getMesesUso($fechaINICIAL);  ?></font> </td>
                        <td style="text-align:right"><font size="-1"><?php echo $data->getAnioUso($fechaINICIAL);  ?></font> </td>                    
                        <td style="text-align:right"><font size="-1"><?php echo Parametro::formato($data->getDepreAcumuladaMesAnterior ($fechaINICIAL) , true);  ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo Parametro::formato($data->getDepreAcumulada($fechaINICIAL),true);  ?></font></td>
                        <td style="text-align:right"><font size="-1"><?php echo Parametro::formato($valorLibros,true);  ?></font></td>
                        
                        <td style="text-align:center; align-content: center" ><font size="-1"><?php if (!$data->getVencido()) { ?><i class="flaticon2-check-mark"></i>  <?php } ?></font> </td>
          
                    </tr>
                                  <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>


<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Detalle Partida</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>



<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>