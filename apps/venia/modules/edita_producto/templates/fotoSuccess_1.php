<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
 <?php include_partial("soporte/avisos"); ?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-tasks font-blue"></i>
            <span class="caption-subject bold font-blue uppercase">Editar Producto</span>
            <span class="caption-helper">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <div class="portlet-input input-inline input-small">
   
            </div>
       
        </div>
         <div class="inputs">
         <a class="btn  btn blue-steel "  href="<?php echo url_for($modulo . '/index') ?>" ><i class="fa fa-hand-o-left"></i> Retornar </a>
        
        </div>
    </div>
    <div class="portlet-body">
           <?php echo $form->renderFormTag(url_for($modulo . '/foto?id='.$id), array('class' => 'form')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4 bold Bold uppercase font-blue"><?php echo $registro->getNombre(); ?></div>

   
        </div>
        
        <div class="row">
             <div class="col-md-1"></div>
            <div class="col-md-2">Promocional</div>
            <div class="col-md-2"> <?php echo $form['promocional'] ?>     </div>
            
        </div>
        
            <div class="row">
             <div class="col-md-1"></div>
            <div class="col-md-2">Traslado</div>
            <div class="col-md-2"> <?php echo $form['traslado'] ?>     </div>
            
        </div>
        
            <div class="row">
             <div class="col-md-1"></div>
            <div class="col-md-2">Top Venta</div>
            <div class="col-md-2"> <?php echo $form['top_venta'] ?>     </div>
            
        </div>
        
            <div class="row">
             <div class="col-md-1"></div>
            <div class="col-md-2">Salida</div>
            <div class="col-md-2"> <?php echo $form['salida'] ?>     </div>
            
        </div>
        
            <div class="row">
             <div class="col-md-1"></div>
            <div class="col-md-2">Opcion Combo</div>
            <div class="col-md-2"> <?php echo $form['opcion_combo'] ?>     </div>
            
        </div>
        
        
        <div class="row">
                <div class="col-md-1"></div>
            <div class="col-md-2">Bodega Interna</div>
            <div class="col-md-2"> <?php echo $form['bodega_interna'] ?>     </div>
            
        </div>
        
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2">Foto</div>
            <div class="col-md-2">            
              <?php include_partial($modulo.'/imagen', array('form'=>$form, 'url' => $url, 'modulo' => $modulo)) ?>
            </div>
                <div class="col-md-2">
        <br><br>
        <button class="btn btn-block blue-hoki btn-block btn-outline " type="submit">
            <i class="fa fa-check"></i>
            Guardar
        </button>
    </div>
        </div>
             <div class="row">
         <div class="col-md-4"></div>
     
     
          </div>
           <?php echo '</form>'; ?>     
    </div>
</div>