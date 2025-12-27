<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?tipo='.$tipo), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
        <div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
               <h3 class="kt-portlet__head-title kt-font-brand">
                   Carga de Archivo 
            </h3>
             </div>
       <div class="kt-portlet__head-toolbar">
   
       </div>
   
   
    </div>
    <div class="kt-portlet__body">

            <div class="row">
                <div class="col-lg-1"> </div>        
                <label class="col-lg-2 control-label right ">Archivo </label>
                <div class="col-lg-8 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
                    <?php echo $form['archivo'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['archivo']->renderError() ?>  
                    </span>
                 </div>
            </div>
           <div class="row">
              <div class="col-lg-8">
                 <div class="caption font-red-sunglo" id='alertar' style="display:none;">
                      <span class="caption-subject bold font-red uppercase">Archivo No valido  ( Extensión permitida xls)</span>
                      
                  </div>
              </div>
                <div class="col-lg-2" id ='buton' xstyle="display:none;">
                    <button  id="guarda" name="guarda" class="btn btn-success btn-elevate btn-elevate-air" type="submit">
                        <i class="fa fa-check-circle-o "></i>
                        <span>Procesar</span>
                    </button>
                </div>
            </div>
        </div>
        </div>
    <?php echo '</form>'; ?>

    
<!--        <script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_archivo").on('change', function () {
            var id = $("#consulta_archivo").val();
             var pre=  id.length-3;
             var res = id.substring(pre, pre+3);
             var extensi = res.toLowerCase();
             if (extensi=='xls') {
                $('#buton').slideToggle(250);
                 $('#alertar').hide();
             } else {
                 $('#alertar').slideToggle(250);
                 $('#buton').hide();
             }
             
                 
                
         
        });

    });
</script>-->

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>