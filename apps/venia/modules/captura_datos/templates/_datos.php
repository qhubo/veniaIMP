<div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Tipo Establecimiento<font color="red" size="+2">*</font> </div>
            <div class="col-lg-4 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Propietario </div>
            <div class="col-lg-8 <?php if ($form['propietario']->hasError()) echo "has-error" ?>">
                <?php echo $form['propietario'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['propietario']->renderError() ?>  
                </span>
            </div>
        </div>
       <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Teléfono <font color="red" size="+2">*</font></div>
            <div class="col-lg-4 <?php if ($form['telefono']->hasError()) echo "has-error" ?>">
                <?php echo $form['telefono'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['telefono']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Correo  </div>
            <div class="col-lg-6 <?php if ($form['email']->hasError()) echo "has-error" ?>">
                <?php echo $form['email'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['email']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Región </div>
            <div class="col-lg-5 <?php if ($form['region']->hasError()) echo "has-error" ?>">
                <?php echo $form['region'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['region']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:2px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Departamento  </div>
            <div class="col-lg-5 <?php if ($form['departamento']->hasError()) echo "has-error" ?>">
                <?php echo $form['departamento'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['departamento']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:2px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Municipio  <font color="red" size="+2">*</font></div>
            <div class="col-lg-5 <?php if ($form['municipio']->hasError()) echo "has-error" ?>">
                <?php echo $form['municipio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['municipio']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Dirección </div>
            <div class="col-lg-8 <?php if ($form['direccion']->hasError()) echo "has-error" ?>">
                <?php echo $form['direccion'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['direccion']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Nit </div>
            <div class="col-lg-4 <?php if ($form['nit']->hasError()) echo "has-error" ?>">
                <?php echo $form['nit'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['nit']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Contacto  </div>
            <div class="col-lg-8 <?php if ($form['contacto']->hasError()) echo "has-error" ?>">
                <?php echo $form['contacto'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['contacto']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >WhatsApp </div>
            <div class="col-lg-4 <?php if ($form['WhtasApp']->hasError()) echo "has-error" ?>">
                <?php echo $form['WhtasApp'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['WhtasApp']->renderError() ?>  
                </span>
            </div>
        </div>
        <div class="row " style='padding-top:4px;'>
            <div class="col-lg-1"></div>
            <div class="col-lg-2 titulo" >Observaciones <font color="red" size="+2">*</font></div>
            <div class="col-lg-8 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div>
        </div>
