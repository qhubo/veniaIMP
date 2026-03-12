
  <?php $modulo = $sf_params->get('module'); ?> 
<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<?php $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId); ?>
<?php $TIPO_USUARIO =strtoupper($usuarioQ->getTipoUsuario()); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info"> REPORTE DE PRECIOS ACTUALIZADOS
                <small>&nbsp;&nbsp;&nbsp; filtra por un rango de fechas y producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        <div class="actions">
           <a class="btn  btn grey-cascade  "  target="_blank"  href="<?php echo url_for($modulo . '/reporte') ?>" ><i class="fa fa-list"></i>&nbsp;&nbsp;Reporte&nbsp;&nbsp;  <i class="fa fa-print"></i></a>
     
        </div>

        </div>
    </div>
    <div class="kt-portlet__body">

        <?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        
              <div class="row" style="padding-top:5px;">
                    <label class="col-lg-1 control-label right ">Nombre  </label>
            <div class="col-lg-4 <?php if ($form['nombrebuscar']->hasError()) echo "has-error" ?>">
                <?php echo $form['nombrebuscar'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nombrebuscar']->renderError() ?>  
                </span>
            </div>
           
        </div>
        
        
           <div class="row" style="padding-top:5px; padding-bottom:10px;">
          
            <label class="col-lg-1 control-label right "><span class="font-blue bold Bold"> Fecha Inicio </span>  </label>
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <label class="col-lg-1 control-label right "><span class="font-blue bold Bold">Fecha Fin</span>  </label>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
              
  
               <div class="col-lg-2">
                <button class="btn  btn-sm  btn-success " type="submit">
                    <i class="fa fa-search "></i> Consultar
                </button>
            </div>
        </div>



        



        <?php echo '</form>'; ?>
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


        <div class="table-scrollable">
                <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">


                <thead class="flip-content">
                    <tr class="info">
                        <th  align="center">Código</th>
                        <th  align="center">Fecha</th>                               
                        <th  align="center">Producto</th>     
                        <th  align="center">Tipo</th>
                        <th  align="center">Usuario</th>   
                        <th  align="center">Precio</th>
                        <th  align="center">Precio Lista</th>    
                         <th  align="center">Identificador</th>    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($registros as $data) { ?>
                    <tr>
                        <td><?php echo $data['codigo_sku'];  ?></td>
                        <td  style="text-align: center;"><?php echo $data['fecha'];  ?></td>
                        <td><?php echo $data['nombre'];  ?></td>
                        <td><?php echo $data['tipo'];  ?></td>
                        <td><?php echo $data['usuario'];  ?></td>
                        <td style="text-align: right;"><?php echo Parametro::formato($data['precio']);  ?></td>  
                        <td  style="text-align: right;"><?php if ($data['precio_lista']>0) { echo Parametro::formato($data['precio_lista']); }  ?></td>  
                        <td><?php echo $data['producto_id'];  ?></td>  
                    </tr>
                    <?php } ?>
                </tbody>
         
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


