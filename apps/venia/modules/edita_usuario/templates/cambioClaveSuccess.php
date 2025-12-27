<?php $modulo = $sf_params->get("module"); ?>






<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-more-1 kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Cambio de Clave  
                <small></small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>

    <div class="portlet-body form">
        <div class="row">
            <div class="col-lg-2"></div>
                        <div class="col-lg-2">Usuario</div>
            <div class="col-lg-5 kt-font-brand"> <?php echo $usuariodescripcion->getUsuario() ?> </div>            
        </div>
    <div class="panel-body">

 
        <?php echo $form->renderFormTag(url_for($modulo . "/cambioClave?id=".$usuariodescripcion->getId()), array("class" => "form ",)); ?>
<?php echo $form->renderHiddenFields() ?>
        <div class="row">
    <div class="col-lg-1"> </div>      
    <label class="col-lg-3 control-label font-blue-steel right ">Nueva Clave  </label>
    <div class="col-lg-5 <?php if ($form['nueva']->hasError()) echo "has-error" ?>">
        <?php echo $form['nueva'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['nueva']->renderError() ?>  
        </span>
    </div>
</div>   
      
        
               <div class="row">
    <div class="col-lg-1"> </div>      
    <label class="col-lg-3 control-label font-blue-steel right ">Confirma Clave  </label>
    <div class="col-lg-5 <?php if ($form['verifica']->hasError()) echo "has-error" ?>">
        <?php echo $form['verifica'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['verifica']->renderError() ?>  
        </span>
    </div>
</div> 
        <br/><br/>

            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-2">           
            <button type="button" data-dismiss="modal"  class="btn btn-secondary btn-dark">Cancelar</button>
   
 </div>
                <div class="col-lg-1"> </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-success btn-block">
                <i class="fa fa-check"></i>
               Cambiar
            </button>  </div>
            </div>

           
        <?php echo "</FORM>"; ?>
    </div>

</div>
        </div>

<!--<style>
    .cambiar_boton{
        display: none;
    }




</style>-->

<!--
<script>
 

$( document ).ready(function() {
      
    $( "#clave_nueva" ).keyup(function() {
   
var clave1 = document.getElementById("clave_nueva").value
var clave2 = document.getElementById("clave_verifica").value
alert(clave1);
  if(clave1 == clave2){
        $(".cambiar_boton").show()
}else{
    $(".cambiar_boton").hide()
}
});

$( "#clave_verifica" ).keyup(function() {
var clave1 = document.getElementById("clave_nueva").value
var clave2 = document.getElementById("clave_verifica").value
  if(clave1 == clave2){
        $(".cambiar_boton").show()
}else{
    $(".cambiar_boton").hide()
}
});

});
</script>-->