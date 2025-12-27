<?php echo $form->renderFormTag(url_for($modulo . '/muestra?id=' . $id), array("class" => "form-vertical login-form",)); ?>
<?php echo $form->renderHiddenFields() ?>       
<div class="row"  style="padding-bottom: 5px; ">

    <div class=" col-lg-1 " >Nombre</div>
    <div class="col-lg-8   <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
        <?php echo $form['nombre'] ?>     
    </div>
</div>
<div class="row"  style="padding-bottom: 5px; ">
  <div class=" col-lg-2 " >Descripción</div>
    <div class="col-lg-7   <?php if ($form['descripcion']->hasError()) echo "has-error" ?>">
        <?php echo $form['descripcion'] ?>     
    </div>
      </div>


<div class="row"  style="padding-bottom: 5px; ">
    <div class=" col-lg-2 " >Código Sku</div>
    <div class="col-lg-3   <?php if ($form['codigo_sku']->hasError()) echo "has-error" ?>">
        <input class="form-control" placeholder="* Código Automatico " type="text" name="consulta[codigo_sku]" <?php if ($combo) { ?>  value="<?php echo $combo->getCodigoSku(); ?>" readonly="true" <?php } ?>  id="consulta_codigo_sku">  
    </div>
   <div class="col-md-1" id="vali" style="display: none;"> <font color="red" size="-2"> Codigo Ya existe</font>
                                    <input id="te" name="te" readonly="" >
                                </div>
    
     <div class=" col-lg-1 " >Precio </div>
    <div class="col-lg-2   <?php if ($form['precio']->hasError()) echo "has-error" ?>">
        <?php echo $form['precio'] ?>     
    </div>
<!--    <div class=" col-lg-2 " >Código Barras </div>
    <div class="col-lg-2   <?php if ($form['codigo_barras']->hasError()) echo "has-error" ?>">
        <?php echo $form['codigo_barras'] ?>     
    </div>-->
</div>



<div class="row">

    <div class="col-lg-1"></div>
    <div class="col-lg-1">

    </div>
</div>

<div class="row">
<!--    <div class=" col-lg-1 " >Precio </div>
    <div class="col-lg-2   <?php if ($form['precio']->hasError()) echo "has-error" ?>">
        <?php echo $form['precio'] ?>     
    </div>-->
<!--    <div class=" col-lg-2 " style="text-align: right" >Precio Variable</div>
    <div class="col-lg-1   <?php if ($form['precio_variable']->hasError()) echo "has-error" ?>">
        <?php echo $form['precio_variable'] ?>     
    </div>-->
    <div class="col-lg-1"></div>

</div>



<!--<div class="row">    
    <div class="col-lg-1"></div>
    <div class="col-lg-1 ">Imagen </div>

    <div class="col-lg-3 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
        <?php echo $form['archivo'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['archivo']->renderError() ?>  
        </span>
    </div>
</div>-->


 <div class="row">
        <div class="col-lg-12">  <br></div>
    </div>
    <div class="row">

            <div class=" col-lg-6 " style="text-align: right" >Activo </div>
    <div class="col-lg-1   <?php if ($form['activo']->hasError()) echo "has-error" ?>">
        <?php echo $form['activo'] ?>     
    </div>
       
      
        
        <div class="col-lg-5">
            <button class="btn btn-info " type="submit">
                <i class="fa fa-save"></i>  Guardar
            </button>
        </div>
        
        <div class="col-lg-1"></div>
   
         
    </div>
   
<script src='/assets/global/plugins/jquery.min.js'></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_codigo_sku").on('change', function () {
            var id = $("#consulta_codigo_sku").val();
            var idv = $("#sec").val();
            $.get('<?php echo url_for("edita_producto/codigo") ?>', {id: id, idv: idv}, function (response) {
                if (response==1){
                $("#vali").slideToggle(250);
                $("#consulta_codigo_sku").val('');
                  $("#te").val(id);
               } 
               if (response==0){
                $("#vali").hide();
              
               }
            });
         
        });

    });
</script>

<?php echo '</FORM>'; ?>
