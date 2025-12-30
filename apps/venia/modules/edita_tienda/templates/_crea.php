


                    <div class="row">
                        
                            <div  class="col-lg-2">
                          Código Establecimiento   
                        </div>
                        <div class="col-lg-1  <?php if ($form['codigo_establecimiento']->hasError()) echo "has-error" ?>">
                            <?php echo $form['codigo_establecimiento'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['codigo_establecimiento']->renderError() ?>       
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
                        
                        
                    
                        
                        
                        
                             <div  class="col-lg-1">
                            Tipo     
                        </div>

                        <div class="col-lg-2   <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                            <?php echo $form['tipo'] ?>      
                            <div  for="consulta_tipo"><span></span></div>
                            <span class="help-block form-error"> 
                                <?php echo $form['tipo']->renderError() ?>       
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
                            Nombre Comercial    
                        </div>
                        <div class="col-lg-9   <?php if ($form['nombre_comercial']->hasError()) echo "has-error" ?>">
                            <?php echo $form['nombre_comercial'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['nombre_comercial']->renderError() ?>       
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
                        <div class="col-lg-4   <?php if ($form['correo']->hasError()) echo "has-error" ?>">
                            <?php echo $form['correo'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['correo']->renderError() ?>       
                            </span>
                        </div>
                    </div>
         
                  
            
