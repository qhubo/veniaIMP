
<div class="row">
    <div class="col-md-1"> </div>        
    <label class="col-md-2 control-label font-green-dark right ">Nombre Comercial  </label>
    <div class="col-md-8 <?php if ($form['nombre_comercial']->hasError()) echo "has-error" ?>">
        <?php echo $form['nombre_comercial'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['nombre_comercial']->renderError() ?>  
        </span>
    </div>
    <div class="col-md-1">  </div>
</div>
<div class="row">
    <div class="col-md-1"> </div>        
    <label class="col-md-2 control-label font-green-dark right ">Direccion </label>
    <div class="col-md-8 <?php if ($form['direccion']->hasError()) echo "has-error" ?>">
        <?php echo $form['direccion'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['direccion']->renderError() ?>  
        </span>
    </div>
    <div class="col-md-1">  </div>
</div>

<div class="row">
    <div class="col-md-1"> </div>      
    <label class="col-md-2 control-label font-green-dark right ">Nit </label>
    <div class="col-md-3 <?php if ($form['nit']->hasError()) echo "has-error" ?>">
        <?php echo $form['nit'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['nit']->renderError() ?>  
        </span>
    </div>
    <div class="col-md-1"> </div>  
    <label class="col-md-1 control-label font-green-dark right ">Telefono </label>
    <div class="col-md-3 <?php if ($form['telefono']->hasError()) echo "has-error" ?>">
        <?php echo $form['telefono'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['telefono']->renderError() ?>  
        </span>
    </div>
    <div class="col-md-1">  </div>
</div>  

<div class="row">
    <div class="col-md-1"> </div>        
    <label class="col-md-2 control-label font-green-dark right ">Eslogan Venta </label>
    <div class="col-md-8 <?php if ($form['slogan_venta']->hasError()) echo "has-error" ?>">
        <?php echo $form['slogan_venta'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['slogan_venta']->renderError() ?>  
        </span>
    </div>
    <div class="col-md-1">  </div>
</div>
<div class="row">
    <div class="col-md-1"> </div>        
    <label class="col-md-2 control-label font-green-dark right ">Color  </label>
    <div class="col-md-3 <?php if ($form['color']->hasError()) echo "has-error" ?>">
        <?php echo $form['color'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['color']->renderError() ?>  
        </span>
    </div>

        <label class="col-md-2 control-label font-green-dark right ">No Afiliación </label>
    <div class="col-md-3 <?php if ($form['no_afiliacion']->hasError()) echo "has-error" ?>">
        <?php echo $form['no_afiliacion'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['no_afiliacion']->renderError() ?>  
        </span>
    </div>        
</div>






<div class="row">
      <div class="col-md-3">  </div>
        <div class="col-md-8">  
  <div class="panel-heading">
            <b> Cambia tu Logo </b>
        </div>
            </div>
    </div>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-3">
        <span class="font-blue bold Bold" >Actual</span><br>
           <img src="<?php echo  '/uploads/segmento/'. $logo ?>" height="48px" >
    </div>
    <div   class="col-md-3  <?php if ($form['archivo']->hasError()) echo "has-error"  ?>">
        <span class="font-blue bold Bold" >Nuevo</span>
        <br>
        <?php  echo $form['archivo'] ?>           
        <span class="help-block form-error"> 
            <?php  echo $form['archivo']->renderError() ?>  
        </span>

    </div>
</div>
