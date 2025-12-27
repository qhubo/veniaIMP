

<div class="row">
    <div class="col-lg-1"> </div>        

    <label class="col-lg-2 control-label font-blue-steel right ">Nombre <font color="#E08283" size="-2">*</font>  </label>
    <div class="col-lg-5 <?php if ($form['nombre_completo']->hasError()) echo "has-error" ?>">
        <?php echo $form['nombre_completo'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['nombre_completo']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-3 kt-font-danger" >
        <div id="valid" class="valid" style="display:none;"> Usuario Ya Existe </div>
    </div>

</div>



<div class="row">
    <div class="col-lg-1"> </div>        
    <label class="col-lg-2 control-label font-blue-steel right ">Usuario<font color="#E08283" size="-2">*</font>  </label>
    <div class="col-lg-3 <?php if ($form['usuario']->hasError()) echo "has-error" ?>">
        <?php echo $form['usuario'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['usuario']->renderError() ?>  
        </span>
    </div>
    <label class="col-lg-1 control-label font-blue-steel right ">Correo  </label>
    <div class="col-lg-4 <?php if ($form['correo']->hasError()) echo "has-error" ?>">
        <?php echo $form['correo'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['correo']->renderError() ?>  
        </span>
    </div>

</div>


<div class="row">
    <div class="col-lg-1"> </div>      

</div>    



<div class="row">
    <div class="col-lg-1"> </div>
    <div class="col-lg-2">Tipo Acceso</div>
    <div class="col-lg-3 <?php if ($form['tipo']->hasError()) echo "has-error" ?>" >       
 <?php echo $form['tipo'] ?> </div>
  
     <span class="help-block font-red-flamingo form-error"> 
            <?php echo $form['tipo']->renderError() ?>  
        </span>
    <div class="col-lg-1"> </div>


    <div class="col-lg-1 font-blue bold"  <?php if ($id) { ?> style="display:none;"  <?php } ?>>Clave </div>
    <div class="col-lg-3 " <?php if ($id) { ?> style="display:none;"  <?php } ?>><?php echo $form['clave'] ?> </div>

</div>



<!--<div class="row">
    <div class="col-lg-1"> </div>
    <div class="col-lg-2">Nivel Acceso</div>
    <div class="col-lg-3"> <?php echo $form['nivel'] ?> </div>
    <div class="col-lg-1"> </div>
</div>-->
<div class="row">
    <div class="col-lg-1"> </div>
    <div class="col-lg-2">Empresa</div>
    <div class="col-lg-3"> <?php echo $form['empresa'] ?> </div>
    <div class="col-lg-1"> </div>
</div>
<div class="row">
    <div class="col-lg-1"> </div>
    <div class="col-lg-2">Bodega</div>
    <div class="col-lg-3 <?php if ($form['bodega']->hasError()) echo "has-error" ?>"> 
        
        <?php echo $form['bodega'] ?> 
       <span class="help-block font-red-flamingo form-error"> 
            <?php echo $form['bodega']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1"> </div>
</div>
<div class="row">
    <div class="col-lg-1"> </div>
    <div class="col-lg-2">Vendedor</div>
    <div class="col-lg-3 <?php if ($form['vendedor_id']->hasError()) echo "has-error" ?>"> 
        
        <?php echo $form['vendedor_id'] ?> 
       <span class="help-block font-red-flamingo form-error"> 
            <?php echo $form['vendedor_id']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1"> </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#consulta_usuario").on('change', function () {
            var id = $("#consulta_usuario").val();
            var idv = $("#sec").val();
            $.get('<?php echo url_for("edita_usuario/codigo") ?>', {id: id, idv: idv}, function (response) {
                if (response == 1) {

                    $("#valid").show();
                    $("#consulta_usuario").val('');
                    $("#te").val(id);
                }
                if (response == 0) {
                    $("#valid").hide();

                }
            });

        });

    });
</script>


