<div class="row">

    <div class="col-lg-2  ">Nombre</div>
    <div class="col-lg-6 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
        <?php echo $form['nombre'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['nombre']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1  ">Codigo Escenario</div>
    <div class="col-lg-2 <?php if ($form['nomenclatura']->hasError()) echo "has-error" ?>">
        <?php echo $form['nomenclatura'] ?>           
    </div>
</div>
<div class="row">
    <div class="col-lg-2  ">Dirección</div>
    <div class="col-lg-6 <?php if ($form['direccion']->hasError()) echo "has-error" ?>">
        <?php echo $form['direccion'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['direccion']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1  ">NIT</div>
    <div class="col-lg-2 <?php if ($form['telefono']->hasError()) echo "has-error" ?>">
        <?php echo $form['telefono'] ?>           
    </div>
</div>
<div class="row">

    <div class="col-lg-2  ">Departamento</div>
    <div class="col-lg-6 <?php if ($form['departamento']->hasError()) echo "has-error" ?>">
        <?php echo $form['departamento'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['departamento']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1  ">Municipio</div>
    <div class="col-lg-2 <?php if ($form['municipio']->hasError()) echo "has-error" ?>">
        <?php echo $form['municipio'] ?>           
    </div>
</div>

<div class="row">
    <div class="col-lg-2  ">Mapa Geo</div>
    <div class="col-lg-6 <?php if ($form['mapa_geo']->hasError()) echo "has-error" ?>">
        <?php echo $form['mapa_geo'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['mapa_geo']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1"></div>
    <div class="col-lg-1">
        <br>
        <img src="<?php echo $urlImagen ?>"  width="100px">
        
    </div>
</div>
<div class="row">


    <div class="col-lg-2  ">Telefono</div>
    <div class="col-lg-2 <?php if ($form['contacto_telefono']->hasError()) echo "has-error" ?>">
        <?php echo $form['contacto_telefono'] ?>   
          
    </div>
    <div class="col-lg-2"> <?php echo $form['contacto_movil'] ?>  </div>
    
</div>
<div class="row">
    <div class="col-lg-2  ">Imagen</div>
    <div class="col-lg-2 <?php if ($form['archivo']->hasError()) echo "has-error" ?>">
        <font size='-3'>     <?php echo $form['archivo'] ?>  </font>          
    </div>
</div>



