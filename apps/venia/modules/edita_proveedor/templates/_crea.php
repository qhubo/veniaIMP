


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
                            Razón Social     
                        </div>
                        <div class="col-lg-9   <?php if ($form['razon_social']->hasError()) echo "has-error" ?>">
                            <?php echo $form['razon_social'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['razon_social']->renderError() ?>       
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
                            Tipo Proveedor     
                        </div>
                        <div class="col-lg-4    
                             <?php if ($form['tipo_proveedor']->hasError()) echo "has-error" ?>">
                                 <?php echo $form['tipo_proveedor'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['tipo_proveedor']->renderError() ?>       
                            </span>
                        </div>


                        <div  class="col-lg-2">
                            Dia Credito     
                        </div>
                        <div class="col-lg-3   <?php if ($form['dias_credito']->hasError()) echo "has-error" ?>">
                            <?php echo $form['dias_credito'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['dias_credito']->renderError() ?>       
                            </span>
                        </div>     
                    </div>


                    <div class="row">

                        <div  class="col-lg-2">
                            Sitio Web     
                        </div>
                        <div class="col-lg-8   <?php if ($form['sitio_web']->hasError()) echo "has-error" ?>">
                            <?php echo $form['sitio_web'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['sitio_web']->renderError() ?>       
                            </span>
                        </div>  
                    </div>

                    <div class="row">
                        <div  class="col-lg-2">
                            Contacto     
                        </div>
                        <div class="col-lg-4   <?php if ($form['contacto']->hasError()) echo "has-error" ?>">
                            <?php echo $form['contacto'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['contacto']->renderError() ?>       
                            </span>
                        </div>

                        <div  class="col-lg-2">
                            Correo Contacto
                        </div>
                        <div class="col-lg-3   <?php if ($form['correo_contacto']->hasError()) echo "has-error" ?>">
                            <?php echo $form['correo_contacto'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['correo_contacto']->renderError() ?>       
                            </span>
                        </div>
                    </div>




              
                    <div class="row">
                        <div  class="col-lg-2">
                            Teléfono Contacto
                        </div>

                        <div class="col-lg-3   <?php if ($form['telefono_contacto']->hasError()) echo "has-error" ?>">
                            <?php echo $form['telefono_contacto'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['telefono_contacto']->renderError() ?>       
                            </span>
                        </div>
   <div  class="col-lg-2">
                            Regimen ISR
                        </div>

                        <div class="col-lg-3   <?php if ($form['tipo_regimen']->hasError()) echo "has-error" ?>">
                            <?php echo $form['tipo_regimen'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['tipo_regimen']->renderError() ?>       
                            </span>
                        </div>
                        
                    </div>


                  
               <div class="row">

<div  class="col-lg-1">
                          Retiene Iva   
                        </div>

                        <div class="col-lg-1   <?php if ($form['RetieneIva']->hasError()) echo "has-error" ?>">
                            <?php echo $form['RetieneIva'] ?>      
                            <div  for="consulta_RetieneIva"><span></span></div>
                            <span class="help-block form-error"> 
                                <?php echo $form['RetieneIva']->renderError() ?>       
                            </span>

                        </div>  


<div  class="col-lg-1">
                         Exento Isr 
                        </div>

                        <div class="col-lg-1   <?php if ($form['ExentoIsr']->hasError()) echo "has-error" ?>">
                            <?php echo $form['ExentoIsr'] ?>      
             
                            <span class="help-block form-error"> 
                                <?php echo $form['ExentoIsr']->renderError() ?>       
                            </span>

                        </div>  


<div  class="col-lg-1">
                          Retiene ISR
                        </div>

                        <div class="col-lg-1   <?php if ($form['RetineIsr']->hasError()) echo "has-error" ?>">
                            <?php echo $form['RetineIsr'] ?>      
                            <div  for="RetineIsr"><span></span></div>
                            <span class="help-block form-error"> 
                                <?php echo $form['RetineIsr']->renderError() ?>       
                            </span>

                        </div>  
             </div>  
 <div class="row">
<div  class="col-lg-2">
                          Cuenta Contable
                        </div>

                        <div class="col-lg-3   <?php if ($form['cuenta_contable']->hasError()) echo "has-error" ?>">
                            <?php echo $form['cuenta_contable'] ?>      
                            <div  for="cuenta_contable"><span></span></div>
                            <span class="help-block form-error"> 
                                <?php echo $form['cuenta_contable']->renderError() ?>       
                            </span>

                        </div>  
             </div>  