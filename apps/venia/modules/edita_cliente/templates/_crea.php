


<div class="row">

    <div  class="col-lg-2">
        Nit     
    </div>
    <div class="col-lg-2  <?php if ($form['nit']->hasError()) echo "has-error" ?>">
        <?php echo $form['nit'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['nit']->renderError() ?>       
        </span>
    </div>

    <?php if (!$proveedor) { ?>
        <div  class="col-lg-1">
            Código     
        </div>
        <div class="col-lg-2   <?php if ($form['codigo']->hasError()) echo "has-error" ?>">
            <?php echo $form['codigo'] ?>          
            <span class="help-block form-error"> 
                <?php echo $form['codigo']->renderError() ?>       
            </span>
            <font size="-2">* Se crea automático </font>
        </div>
    <?php } ?>





    <div  class="col-lg-1">
        Activo     
    </div>

    <div class="col-lg-1   <?php if ($form['activo']->hasError()) echo "has-error" ?>">
        <?php echo $form['activo'] ?>      
        <div  for="consulta_activo"><span></span></div>
        <span class="help-block form-error"> 
            <?php echo $form['activo']->renderError() ?>       
        </span>

    </div>    




</div>




<div class="row">
    <div  class="col-lg-2">
        Nombre   *
    </div>
    <div class="col-lg-9   <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
        <?php echo $form['nombre'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['nombre']->renderError() ?>       
        </span>
    </div>
</div>




<div class="row">

    <div  class="col-lg-2">
        País     
    </div>
    <div class="col-lg-3   <?php if ($form['pais']->hasError()) echo "has-error" ?>">
        <?php echo $form['pais'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['pais']->renderError() ?>       
        </span>
    </div>


</div> 







<div class="row">

    <div  class="col-lg-2">
        Departamento     
    </div>
    <div class="col-lg-3   <?php if ($form['departamento']->hasError()) echo "has-error" ?>">
        <?php echo $form['departamento'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['departamento']->renderError() ?>       
        </span>
    </div>

    <div  class="col-lg-2">
        Municipio     
    </div>
    <div class="col-lg-4   <?php if ($form['municipio']->hasError()) echo "has-error" ?>">
        <?php echo $form['municipio'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['municipio']->renderError() ?>       
        </span>
    </div>
</div> 

<div class="row">
    <div  class="col-lg-2">
        Dirección     
    </div>
    <div class="col-lg-9  <?php if ($form['direccion']->hasError()) echo "has-error" ?>">
        <?php echo $form['direccion'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['direccion']->renderError() ?>       
        </span>
    </div>
</div>



<div class="row">
    <div  class="col-lg-2">
        Teléfonos     
    </div>
    <div class="col-lg-4   <?php if ($form['telefono']->hasError()) echo "has-error" ?>">
        <?php echo $form['telefono'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['telefono']->renderError() ?>       
        </span>
    </div>

    <div  class="col-lg-1">
        Correo     
    </div>
    <div class="col-lg-4   <?php if ($form['correo_electronico']->hasError()) echo "has-error" ?>">
        <?php echo $form['correo_electronico'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['correo_electronico']->renderError() ?>       
        </span>
    </div>
</div>

<div class="row">


    <div  class="col-lg-2">
        Limite Crédito     
    </div>
    <div class="col-lg-3   <?php if ($form['limite_credito']->hasError()) echo "has-error" ?>">
        <?php echo $form['limite_credito'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['limite_credito']->renderError() ?>       
        </span>
    </div>     
    <div  class="col-lg-2">
        Tiene Crédito     
    </div>
    <div class="col-lg-3   <?php if ($form['tiene_credito']->hasError()) echo "has-error" ?>">
        <?php echo $form['tiene_credito'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['tiene_credito']->renderError() ?>       
        </span>
    </div>  
</div>




<div class="row">
    <div  class="col-lg-2">
        Conctacto    
    </div>
    <div class="col-lg-4   <?php if ($form['contacto']->hasError()) echo "has-error" ?>">
        <?php echo $form['contacto'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['contacto']->renderError() ?>       
        </span>
    </div>

</div>
